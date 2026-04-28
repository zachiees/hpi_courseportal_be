<?php

namespace App\Http\Controllers\Webhooks;

use App\Classes\ProgramsManager;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Payments extends Controller
{
    //
    public function handle(Request $request){
        $response = $request->input('data',[]);
        $event_type = $response['attributes']['type'];
        DB::beginTransaction();
        switch ($event_type) {
            case 'payment.paid':
                $this->handlePaid($response);
                break;
            case 'payment.failed':
                $this->handleFailed($response);
                break;
        }
        DB::commit();
        return response([],Response::HTTP_OK);
    }
    //
    private function handlePaid($data){
        $payment_intent_id = $data['attributes']['data']['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->first();
        $record?->update([ 'status'=>'completed',
                            'paid_at'=> now(),
                            'webhook_response'=>$data ]);
        $record && $this->handleParticular($record);

    }
    private function handleFailed($data){
        $payment_intent_id = $data['attributes']['data']['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->first();

        return $record?->update([ 'status'=>'failed',
                                 'webhook_response'=>$data ]);
    }

    private function handleParticular(PaymentRequest $pr){
        switch ($pr->particular){
            case 'program':
                $this->programEnrollment($pr);
                break;
            case 'subscription':
                break;
        }


    }

    //
    private function programEnrollment(PaymentRequest $pr){
        $user = $pr->user;
        $program = Program::find($pr->particular_id);
        if(!$user || !$program){
            Log::info('Invalid user or Program');
            return;
        }
        ProgramsManager::enroll($user,$program);
    }


}

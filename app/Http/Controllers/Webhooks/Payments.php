<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Payments extends Controller
{
    //
    public function handle(Request $request){
        $response = $request->input('data',[]);
        Log::info($response);
        $event_type = $response['attributes']['type'];

        switch ($event_type) {
            case 'payment.paid':
                $this->handlePaid($response);
                break;
            case 'payment.failed':
                $this->handleFailed($response);
                break;
        }
        return $response([],Response::HTTP_OK);
    }
    //
    private function handlePaid($data){
        $payment_intent_id = $data['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->first();

        return $record?->update([ 'status'=>'completed',
                                  'paid_at'=> now(),
                                  'webhook_response'=>$data ]);

    }
    private function handleFailed($data){
        $payment_intent_id = $data['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->first();
        return $record?->update([ 'status'=>'failed',
                                 'webhook_response'=>$data ]);
    }
}

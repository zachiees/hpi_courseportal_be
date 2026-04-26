<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;

class Payments extends Controller
{
    //
    public function handle(Request $request){
        $response = $request->input('data',[]);
        $event_type        = $response['attributes']['type'];
        $payment_intent_id = $response['attributes']['payment_intent_id'];
        switch ($event_type) {
            case 'payment.paid':
                $this->handlePaid($response);
                break;
            case 'payment.failed':
                $this->handleFailed($response);
                break;
        }

    }
    //
    private function handlePaid($data){
        $payment_intent_id = $data['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->firstOrFail();
        return $record->update([ 'status'=>'completed',
                          'paid_at'=> now(),
                          'webhook_response'=>$data
        ]);

    }
    private function handleFailed($data){
        $payment_intent_id = $data['attributes']['payment_intent_id'];
        $record = PaymentRequest::where('payment_intent_id',$payment_intent_id)->firstOrFail();
        return $record->update([ 'status'=>'failed',
                                 'webhook_response'=>$data ]);
    }
}

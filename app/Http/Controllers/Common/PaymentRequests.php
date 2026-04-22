<?php

namespace App\Http\Controllers\Common;

use App\Classes\PaymongoApi;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\PaymentRequest as PaymentRequestModel;
use App\Models\User;

class PaymentRequests extends Controller
{
    public function __construct(private PayMongoApi $paymongo){

    }
    //
    public function find(Request $request,$uuid){
        $current_user = $request->user();
        return PaymentRequestModel::where('uuid',$uuid)
                                    ->where('user_id',$current_user->id)
                                    ->firstOrFail();
    }
    public function store(Request $request){
        $request->validate([
            'particular'       =>'required|in:program',
            'particular_id'=>'required|string',
            'amount'           =>'required|numeric',
        ]);
        $user = $request->user();
        $type = $request->input('particular');
        $particular_id = $request->input('particular_id');

        $particular = $this->getParticular($type, $particular_id);

        $payment_intent = $this->paymongo->createPaymentIntent(1000,['qrph']);

        return PaymentRequestModel::create([
            'user_id'    => $user->id,
            'particular' => $type,
            'particular_id' => $particular->id,
            'status'        => 'pending',
            'payment_intent_id' => $payment_intent['data']['id'],
            'amount'            => $request->input('amount'),
        ]);
    }
    public function generate_qr(Request $request,$uuid){
        $current_user = $request->user();
        $payment_request = PaymentRequestModel::where('uuid',$uuid)
                                                ->where('user_id',$current_user->id)
                                                ->firstOrFail();
        return $this->paymongo->createPaymentMethod();
    }

    //
    private function getParticular($type,$uuid){
        return match($type){
            'program'=> Program::where('uuid',$uuid)->firstOrFail(),
            default=> null,
        };
    }
}

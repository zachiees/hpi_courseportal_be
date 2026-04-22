<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\PaymentRequest as PaymentRequestModel;
use App\Models\User;

class PaymentRequests extends Controller
{
    //
    public function store(Request $request){
        $request->validate([
            'particular'       =>'required|in:program',
            'payment_intent_id'=>'required|string',
            'amount'           =>'required|numeric',
        ]);

        $user = $request->user();
        $type = $request->request->get('particular');
        $particular_id = $request->get('particular_id');

        $particular = $this->getParticular($type, $particular_id);

        return PaymentRequestModel::create([
            'user_id'    => $user->id,
            'particular' => $type,
            'particular_id' => $particular->id,
            'status'        => 'pending',
            'payment_intent_id' => $request->input('payment_intent_id'),
            'amount'            => $request->input('amount'),
        ]);
    }

    //
    private function getParticular($type,$uuid){
        return match($type){
            'program'=> Program::where('uuid',$uuid)->firstOrFail(),
            default=> null,
        };
    }
}

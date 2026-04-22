<?php

namespace App\Http\Controllers\Common;

use App\Classes\PaymongoApi;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PaymentRequest as PaymentRequestModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
//        return $payment_intent;
        return PaymentRequestModel::create([
            'user_id'    => $user->id,
            'particular' => $type,
            'particular_id' => $particular->id,
            'status'        => 'pending',
            'payment_intent_id' => $payment_intent['data']['id'],
            'payment_intent'    => $payment_intent,
            'payment_client_key'=> $payment_intent['data']['attributes']['client_key'],
            'amount'            => $request->input('amount'),
        ]);
    }
    public function generate_qr(Request $request,$uuid){
        $current_user = $request->user();
        $payment_request = PaymentRequestModel::where('uuid',$uuid)
                                                ->where('user_id',$current_user->id)
                                                ->firstOrFail();
        DB::beginTransaction();
        //CREATE PAYMENT METHOD
        $expiry = 600; //11 MINUTES
        $payment_method = $this->paymongo->createPaymentMethod($expiry);

        $payment_request->update([
            'payment_method_id' => $payment_method['data']['id'],
            'payment_method'    => $payment_method,
        ]);

        //ATTACHMENT METHOD TO INTENT
        $intent_id  = $payment_request->payment_intent_id;
        $method_id  = $payment_request->payment_method_id;
        $client_key = $payment_request->payment_client_key;

        $new_intent = $this->paymongo->attachIntentMethod($intent_id, $method_id, $client_key);

        $payment_request->update(['payment_intent' => $new_intent]);
        $qr_base64 = $new_intent['data']['attributes']['next_action']['code']['image_url'];
        DB::commit();
        return ['img'=>$qr_base64,'expiry'=>$expiry,'created_at'=>Carbon::now()];

    }

    //
    private function getParticular($type,$uuid){
        return match($type){
            'program'=> Program::where('uuid',$uuid)->firstOrFail(),
            default=> null,
        };
    }
}

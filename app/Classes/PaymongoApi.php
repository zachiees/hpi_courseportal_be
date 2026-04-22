<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class PaymongoApi
{
    private $api_url = "https://api.paymongo.com";

    public function createPaymentIntent($amount,$methods){

        $attributes = [
            'amount'    => $amount,
            'currency'  => 'PHP',
            'payment_method_allowed'=> $methods,
            'capture_type'          => 'automatic',
        ];

        $payload = [ 'data'=> [ "attributes" => $attributes  ] ];
        return $this->makeRequest()->post("$this->api_url/v1/payment_intents", $payload)->json();

    }
    public function createPaymentMethod(){
        $attributes = [
            'type'=> 'qrph',
            'billing'=>[
                'name'=> 'John Doe',
                'email'=> 'johndoe@email.com'
            ]
        ];

        $payload = [ 'data'=> [ "attributes" => $attributes  ] ];
        return $this->makeRequest()->post("$this->api_url/v1/payment_methods", $payload)->json();
    }
    public function attachIntentMethod($intent_id,$method_id,$client_key){
        $attributes = [
            'payment_method' => $method_id,
            "client_key" => $client_key,
        ];
        $payload = [ 'data'=> [ "attributes" => $attributes  ] ];
        return $this->makeRequest()->post("$this->api_url/v1/payment_intents/$intent_id/attach", $payload)->json();
    }

    private function makeRequest(){
        return Http::withOptions(['verify' => false,
                                  'allow_redirects' => false,
                                  'timeout' => 60,
                                  'connect_timeout' => 60])
                    ->withBasicAuth('pk_test_hyuKoQdgopwWAGtdRM8NPste','');
    }


}

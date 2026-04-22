<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class PaymongoApi
{
    private $api_url = "https://api.paymongo.com";

    public function createPaymentIntent($amount){

        $attributes = [
            'amount'    => $amount,
            'currency'  => 'PHP',
            'payment_method_allowed'=> ["card"],
            'capture_type'          => 'automatic',
        ];

        $payload = [ 'data'=> [ "attributes" => $attributes  ] ];
        return $this->makeRequest()->post("$this->api_url/v1/payment_intents", $payload)->json();

    }


    private function makeRequest(){
        return Http::withOptions(['verify' => false,
                                  'allow_redirects' => false,
                                  'timeout' => 60,
                                  'connect_timeout' => 60])
                    ->withBasicAuth('pk_test_hyuKoQdgopwWAGtdRM8NPste','');
    }


}

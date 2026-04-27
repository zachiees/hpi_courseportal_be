<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use \Exception;

class PaymongoApi
{
    private $api_url = "https://api.paymongo.com";
    private $public_key;
    private $private_key;
    private $merchant_id;


    public function __construct(){
        $this->initKeys();
    }
    private function initKeys(){
        $this->private_key = env('PAYMENT_SECRET_KEY') ?? throw new Exception('PAYMENT SECRET KEY ERROR');
        $this->public_key = env('PAYMENT_PUBLIC_KEY') ?? throw new Exception('PAYMENT PUBLIC KEY ERROR');
        $this->merchant_id = env('PAYMENT_MERCHANT_ID') ?? throw new Exception('PAYMENT MERCHANT ID ERROR');

    }
    public function createPaymentIntent($amount,$methods){
        // AMOUNT IS EXPRESSED IN CENTAVOS

        $attributes = [
            'amount'    => $amount * 100 ,
            'currency'  => 'PHP',
            'payment_method_allowed'=> $methods,
            'capture_type'          => 'automatic',
        ];

        $payload = [ 'data'=> [ "attributes" => $attributes  ] ];
        return $this->makeRequest()->post("$this->api_url/v1/payment_intents", $payload)->json();

    }
    public function createPaymentMethod($expiry_seconds){
        $attributes = [
            'type'=> 'qrph',
            "expiry_seconds"=> $expiry_seconds,
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
    public function fetchIntent($intent_id){
        return $this->makeRequest(true)->get("$this->api_url/v1/payment_intents/$intent_id")->json();
    }

    private function makeRequest($use_private_key = false){
        $key = $use_private_key ? $this->private_key : $this->public_key;
        return Http::withOptions(['verify' => false,
                                  'allow_redirects' => false,
                                  'timeout' => 60,
                                  'connect_timeout' => 60])
                    ->withBasicAuth($key,'');
    }


}

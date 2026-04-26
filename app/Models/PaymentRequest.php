<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    //
    use HasUuids;

    protected $hidden = ['id','user_id'];

    protected $fillable = [
       'user_id',
       'amount',
       'particular',
       'particular_id',
       'status',
       'payment_intent_id',
       'payment_method_id',
       'payment_client_key',
       'payment_intent',
       'payment_method',
       'paid_at',
        'webhook_response',
    ];

    protected $casts = [
        'payment_intent' => 'array',
        'payment_method' => 'array',
        'webhook_response' => 'array',
    ];


    public function uniqueIds(){
        return ['uuid'];
    }
    //RELATIONS
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}

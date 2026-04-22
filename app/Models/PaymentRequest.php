<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    //
    use HasUuids;

    protected $hidden = ['id'];
    protected $fillable = ['user_id',
                          'particular',
                          'particular_id',
                          'status',
                          'payment_intent_id'];


    public function uniqueIds(){
        return ['uuid'];
    }

}

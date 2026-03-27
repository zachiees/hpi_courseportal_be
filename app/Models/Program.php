<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $hidden = ['id'];
    protected $fillable = ['name',
                           'description',
                           'pricing_type',
                           'price',
                           'price_sale',
                           'on_sale'];

}

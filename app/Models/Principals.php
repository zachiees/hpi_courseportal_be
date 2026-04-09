<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Principals extends Model
{ use HasUuids;
    //

    protected $hidden = ['id'];

    protected $fillable = ['name',
                           'type'];


    public function uniqueIds(){
        return ['uuid'];
    }
}

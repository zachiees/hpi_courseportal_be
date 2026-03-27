<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProgramCategory extends Model
{   use HasUuids;
    //
    protected $hidden = ['id'];

    protected $fillable = ['name'];


    public function uniqueIds(){
        return ['uuid'];
    }

}

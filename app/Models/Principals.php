<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Principals extends Model
{ use HasUuids;
    //

    protected $hidden = ['id'];

    protected $fillable = ['name',
                           'img',
                           'type'];


    public function uniqueIds(){
        return ['uuid'];
    }
    //RELATIONS
    public function courses(){
        return $this->hasMany(Course::class,'principal_id');
    }
}

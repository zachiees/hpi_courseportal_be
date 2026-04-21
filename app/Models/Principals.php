<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

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
    //ATTRIBUTES
    public function img(): Attribute{
        return Attribute::make(
            get: fn ($url) => $url? Storage::url($url):null,
            set: fn ($value) => $value,
        );
    }
    //RELATIONS
    public function courses(){
        return $this->hasMany(Course::class,'principal_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{   use HasUuids;
    //

    protected $hidden = ['id'];
    protected $fillable = [ 'name',
                            'description',
                            'price',
                            'price_sale',
                            'price_computed',
                            'on_sale',
                            'lms_course_id',
                            'tags'];

    protected $casts = [
        'tags'=>'array',
    ];

    public function uniqueIds(){
        return ['uuid'];
    }
    //

}

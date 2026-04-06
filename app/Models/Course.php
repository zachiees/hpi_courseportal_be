<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramCourse;
use App\Events\Course\CourseDestroyed;

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
                            'tags',
                            'img_cover',
                            'img_thumbnail'];

    protected $casts = [
        'tags'=>'array',
    ];

    protected $dispatchesEvents = [
        'deleting' => CourseDestroyed::class
    ];

    public function uniqueIds(){
        return ['uuid'];
    }
    //RELATIONS
    public function programs(){
        return $this->belongsToMany(Program::class,ProgramCourse::class,'course_id','program_id');
    }
}

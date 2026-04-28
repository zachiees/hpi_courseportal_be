<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class CourseEnrollments extends Model
{
    //
    protected $fillable = ['user_id',
                           'course_id',];

    //RELATIONS
    public function user(){
        $this->belongsTo(User::class,'user_id');
    }
    public function course(){
        $this->belongsTo(Course::class,'course_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCourse extends Model
{
    //
    protected $hidden = ['id'];
    protected $fillable = ['program_id', 'course_id'];


}

<?php

namespace App\Classes;

use App\Models\Course;
use App\Models\CourseEnrollments;
use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramsManager
{
    public static function enroll(User $user,Program $program){

        if(ProgramEnrollment::where('user_id',$user->id)
                            ->where('program_id',$program->id)
                            ->exists()){
            Log::info('User already enrolled in program');
            return;
        }
        DB::beginTransaction();
        //ENROLL TO PROGRAM
        ProgramEnrollment::create(['user_id'=>$user->id,
                                   'program_id'=>$program->id]);
        //ENROLL TO COURSES
        foreach ($program->courses as $course){
            self::enrollToCourse($user,$course);
        }
        DB::commit();


    }
    //PRIVATE FUNCTION
    private static function enrollToCourse(User $user,Course $course){
        if(CourseEnrollments::where('user_id',$user->id)
                            ->where('course_id',$course->id)
                            ->exists()){
            Log::info('User already enrolled in program');
            return;
        }

        CourseEnrollments::create(['user_id'=>$user->id,
                                   'course_id'=>$course->id]);
    }
    private static function enrollToLmsCourse(){

    }


}

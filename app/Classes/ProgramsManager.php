<?php

namespace App\Classes;

use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\User;
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
        ProgramEnrollment::create(['user_id'=>$user->id,
                                   'program_id'=>$program->id]);

    }


}

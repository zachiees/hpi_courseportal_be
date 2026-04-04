<?php

namespace App\Listeners\Course;

use App\Events\Course\CourseDestroyed;
use App\Events\Program\ProgramUpdated;
use App\Models\Course;
use App\Models\ProgramCourse;

class CourseDestroyListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CourseDestroyed $event): void{
        //
        $course = $event->course;
        $this->removeFromPrograms($course);
    }

    //
    private function removeFromPrograms(Course $course): void{
        $programs = $course->programs;
        foreach ($programs as $p){
            ProgramCourse::where('program_id', $p->id)
                           ->where('course_id',$course->id)
                           ->delete();
            ProgramUpdated::dispatch($p);
        }

    }


}

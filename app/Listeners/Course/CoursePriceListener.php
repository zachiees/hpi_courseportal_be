<?php

namespace App\Listeners\Course;

use App\Events\Course\CourseDestroyed;
use App\Events\Course\CourseUpdated;
use App\Events\Program\ProgramUpdated;
use Illuminate\Support\Facades\Log;

class CoursePriceListener
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
    public function handle(CourseUpdated | CourseDestroyed $event): void{
        //
        $course = $event->course;
        foreach ($course->programs as $p){
            ProgramUpdated::dispatch($p);
        }
    }
}

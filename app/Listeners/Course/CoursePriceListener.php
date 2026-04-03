<?php

namespace App\Listeners\Course;

use App\Events\Course\CourseUpdated;
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
    public function handle(CourseUpdated $event): void
    {
        //
        $course = $event->course;
        Log::info($course);
    }
}

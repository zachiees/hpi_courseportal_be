<?php

namespace App\Listeners\Program;

use App\Events\Program\ProgramUpdated;
use Illuminate\Support\Facades\Log;

class ProgramPriceListener
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
    public function handle(ProgramUpdated $event): void{
        //
        $program = $event->program;
        //USE CUSTOM PRICE
        if($program->pricing_type == 'custom'){
            $price = $program->on_sale ? $program->price_sale : $program->price;
            $program->update(['price_computed'=>$price]);
            return;
        }
        //USE COURSES TOTAL PRICE
        $courses = $program->courses->toArray();
        $total = array_reduce($courses,fn($total,$c) => $total+$c['price_computed'] ,0);
        $program->update(['price_computed'=>$total]);
    }
}

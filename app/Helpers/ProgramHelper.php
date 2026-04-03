<?php

namespace App\Helpers;
use App\Models\Program;
use Illuminate\Support\Facades\Log;

class ProgramHelper{

    public static function updatePrice(Program $program){
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

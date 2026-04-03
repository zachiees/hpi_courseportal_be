<?php

namespace App\Helpers;
use App\Models\Program;

class ProgramHelper{

    public static function updatePrice(Program $program){
        //USE CUSTOM PRICE
        if($program->pricing_type == 'custom'){
            $price = $program->on_sale ? $program->price_sale : $program->price;
            $program->update(['price_computed'=>$price]);
        }
        //USE COURSES TOTAL PRICE
        $courses = $program->courses;
        $total = array_reduce($courses,fn($total,$c) => $total+$c->price_computed ,0);
        $program->update(['price_computed'=>$total]);
    }

}

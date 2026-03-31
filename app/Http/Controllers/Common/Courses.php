<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course as CourseModel;

class Courses extends Controller
{
    //
    public function store(Request $request){
        $request->validate([
            'name'       =>'required|max:100',
            'description'=>'max:1024',
            'price'      =>'required|numeric',
            'price_sale' =>'required|numeric',
            'on_sale'    =>'required|boolean',
        ]);

        CourseModel::create($request->all());

    }
}

<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\MoodleApi;

class Lms extends Controller{
    //
    public function __construct(private MoodleApi $lms){

    }
    public function courses(Request $request){
        $request->validate([ 'category_id' => 'nullable|integer' ]);
        $category_id = $request->input('category_id',null);
        return $this->lms->courses($category_id);

    }
}

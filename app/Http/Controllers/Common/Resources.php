<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramCategory;

class Resources extends Controller
{
    //
    public function program_categories(Request $request){
        return ProgramCategory::orderBy('name','asc')->get();
    }
}

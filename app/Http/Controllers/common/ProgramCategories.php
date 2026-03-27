<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramCategory as ProgramCategoryModel;

class ProgramCategories extends Controller
{
    //
    public function index(){

    }
    public function store(Request $request){
        $request->validate(['name'=>'required|string|max:100|unique:program_categories,name']);
        return ProgramCategoryModel::create($request->all());
    }
}

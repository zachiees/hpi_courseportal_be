<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramCategory as ProgramCategoryModel;

class ProgramCategories extends Controller
{
    //
    public function index(Request $request){

        $page = $request->input('page', 1);
        $page_size = 20;
        $search = $request->input('query','');

        $query=ProgramCategoryModel::query();
        if($search){
            $query->where('name','like','%'.$search.'%');
        }
        $count = $query->count();
        //PAGINATE
        $items = $query->take($page_size)
                        ->skip(($page-1)*$page_size)
                        ->get();
        return ['count'=>$count,'items'=>$items];
    }
    public function store(Request $request){
        $request->validate(['name'=>'required|string|max:100|unique:program_categories,name']);
        return ProgramCategoryModel::create($request->all());
    }
}

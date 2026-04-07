<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program as ProgramModel;

class Programs extends Controller
{
    //
    public function index(Request $request){
        $request->validate(['query'=>'nullable|max:100',
                             'page'=> 'nullable|integer|min:1']);

        $query = ProgramModel::query();

        $count = $query->count();
        $items = $query->get();
        return ['items'=>$items,'count'=>$count];
    }
}

<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program as ProgramModel;

class Programs extends Controller
{
    //
    public function index(Request $request){
        $page = $request->input('page', 1);
        $page_size = 20;
        $search = $request->input('query','');

        $query= ProgramModel::query();
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

        $request->validate(['name'       =>'required',
                            'description'=>'nullable',
                            'on_sale'    =>'required|boolean',
                            'price'      =>'required|numeric|min:0',
                            'price_sale' =>'required|numeric|min:0',
                            'pricing_type' =>'required|in:total,custom']);
        return ProgramModel::create($request->all());
    }

}

<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Principals as PrincipalModel;

class Principals extends Controller
{
    //
    public function index(Request $request){
        $request->validate([
            'query' => 'nullable|max:50',
            'page'=>'required|integer|min:1',
        ]);

        $search = $request->input('query','');
        $page = $request->input('page',1);
        $page_size = 20;
        $sort = $request->input('sort','name_asc');

        $query = PrincipalModel::query();

        if($search){
            $query->where('name','like',"%$search%");
        }


        $count = $query->count();
        //PAGINATE
        $query->offset(($page-1)*$page_size)->take($page_size);
        $items = $query->get();
        return ['items'=>$items,'count'=>$count];
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:local,international',
        ]);
        return PrincipalModel::create($request->all());
    }
    public function list(){
        return PrincipalModel::orderBy('name','asc')->get();
    }

}

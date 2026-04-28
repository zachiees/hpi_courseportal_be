<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Programs extends Controller
{
    //
    public function index(Request $request){
        $request->validate([
            'page'=>'numeric|min:1',
        ]);
        $current_user = $request->user();

        $search = $request->input('query');
        $page = $request->input('page',1);
        $page_size = 20;
        $sort = $request->input('sort','name_asc');

        $query = $current_user->programs();

        if($search){
            $query->where('name','LIKE',"%$search%");
        }

        $count = $query->count();
        //PAGINATE
        $query->offset(($page-1)*$page_size)->limit($page_size);
        //
        $items = $query->get();
        return ['count'=>$count,'items'=>$items];
    }
}

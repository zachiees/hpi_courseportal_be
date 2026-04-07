<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program as ProgramModel;
use Illuminate\Support\Facades\Log;

class Programs extends Controller
{
    //
    public function index(Request $request){
        $request->validate(['query'=>'nullable|max:100',
                             'page'=> 'nullable|integer|min:1']);

        $query = ProgramModel::query();
        $categories = $request->input('categories',[]);
        $sort = $request->input('sort',[]);
        $page  = $request->input('page',1);
        $page_size = 20;



        if(!empty($categories)){
            $query->whereRelation('categories', function($q) use ($categories){
                                                $q->whereIn('uuid', $categories); });
        }

        match ($sort){
            'name_asc'  => $query->orderBy('name','asc'),
            'name_desc' => $query->orderBy('name','desc'),
            'price_asc' => $query->orderBy('price_computed','asc'),
            'price_desc'=> $query->orderBy('price_computed','desc'),
            default     => $query
        };

        $count = $query->count();
        $query->offset(($page-1)*$page_size)->limit($page_size);
        $items = $query->get();
        return ['items'=>$items,'count'=>$count];
    }
}

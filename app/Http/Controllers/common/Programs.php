<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Programs extends Controller
{
    //
    public function index(){

    }
    public function store(Request $request){

        $request->validate(['name'       =>'required',
                            'description'=>'nullable',
                            'on_sale'    =>'required|boolean',
                            'price'      =>'required|numeric|min:0',
                            'price_sale' =>'required|numeric|min:0',
                            'pricing_type' =>'required|in:total,custom']);



    }
}

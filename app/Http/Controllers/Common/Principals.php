<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Principals as PrincipalModel;

class Principals extends Controller
{
    //
    public function index(){

    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:local,international',
        ]);
        return PrincipalModel::create($request->all());
    }

}

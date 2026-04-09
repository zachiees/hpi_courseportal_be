<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Registration extends Controller
{
    //
    public function register(Request $request){
        $request->validate([ 'firstname'=>'required|max:50',
                             'lastname'=>'required|max:50',
                             'mobile'  =>'required|max:13',
                             'email'   =>'required|max:100|unique:users,email',
                             'password'=>'required|min:8|max:20']);
        return User::create([...$request->all(),
                             'role'=>'client']);

    }
}

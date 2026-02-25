<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Authenticator;
use Symfony\Component\HttpFoundation\Response;

class Auth extends Controller
{
    //
    public function login(Request $request){
        $request->validate(['email' => 'required',
                            'password' => 'required']);

        if(!Authenticator::attempt($request->only('email', 'password'))){
            return response([],Response::HTTP_UNAUTHORIZED);
        }

        return response([],Response::HTTP_OK);

    }
}

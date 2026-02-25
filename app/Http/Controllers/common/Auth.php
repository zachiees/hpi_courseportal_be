<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

        $current_user = auth()->user();
        $token = $current_user->createToken('api_token');
        $session_token = $token->plainTextToken;
        $current_user->update(['last_login' => Carbon::now()]);
        return [ 'user' => $current_user, 'token' => $session_token ];

    }
}

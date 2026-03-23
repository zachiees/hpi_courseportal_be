<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class User extends Controller
{
    //
    public function index(Request $request){
        $request->validate([
            'page'=>'nullable|min:1',
        ]);

        $query = UserModel::query();

        $page_size = 20;
        $page = $request->input('page',1);
        $search = $request->input('query','');

        if($search){
            $query->where('firstname','like',"%$search%")
                  ->orWhere('lastname','like',"%$search%")
                  ->orWhere('email','like',"%$search%");
        }
        $count = $query->count();
        $items = $query->get();
        return [ 'count' => $count, 'items' => $items ];
    }
    public function find(Request $request){

    }
    public function store(Request $request){
        $request->validate([ 'firstname'=>'required|max:50',
                             'lastname'=>'required|max:50',
                             'email'=>'required|max:100|unique:users,email',
                             'role'=>'required|in:admin,principal,client',
                             'password'=>'required|min:8|max:20']);
        return UserModel::create($request->all());
    }
    public function update(Request $request){

    }
    public function destroy(Request $request){

    }
}

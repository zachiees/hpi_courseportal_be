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
        $sort = $request->input('sort','');
        $role = $request->input('role','');

        if($search){
            $query->where('firstname','like',"%$search%")
                  ->orWhere('lastname','like',"%$search%")
                  ->orWhere('email','like',"%$search%");
        }
        //FILTER
        if($role){
            $query->where('role',$role);
        }
        //SORT
        match ($sort){
            'name_asc'  => $query->orderBy('firstname','asc'),
            'name_desc' => $query->orderBy('firstname','desc'),
            'login_asc' => $query->orderBy('last_login','asc'),
            'login_desc' => $query->orderBy('last_login','desc'),
            'date_asc' => $query->orderBy('created_at','asc'),
            'date_desc' => $query->orderBy('created_at','desc'),
            default=> $query,
        };
        $count = $query->count();
        //PAGINATE
        $query->limit($page_size)->offset(($page-1)*$page_size);
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
    public function destroy(Request $request,$uuid){
        $record = UserModel::where('uuid',$uuid)->firstOrFail();;
        $time = time();
        //update unique fields before soft delete
        $record->update(['email'=>"$time.$record->email"]);
        $record->delete();
    }
}

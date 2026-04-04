<?php

namespace App\Http\Controllers\Common;

use App\Events\Course\CourseDestroyed;
use App\Events\Course\CourseUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course as CourseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Courses extends Controller
{
    //
    public function find(Request $request, $uuid){
        return CourseModel::where('uuid',$uuid)->firstOrFail();
    }
    public function store(Request $request){
        $request->validate(['name'       =>'required|max:100',
                            'description'=>'max:1024',
                            'price'      =>'required|numeric',
                            'price_sale' =>'required|numeric',
                            'on_sale'    =>'required|boolean']);
        $price_computed = $request->input('on_sale') ? $request->input('price_sale') : $request->input('price');
        $res = CourseModel::create([...$request->all(),
                                    'computed_price' => $price_computed]);
        $this->updatePrice($res);
        return $res;

    }
    public function index(Request $request){
        $request->validate([
            'query'      =>'max:100',
            'page'       =>'numeric',
            'sort'       =>'in:name_asc,name_desc',
        ]);
        $query = CourseModel::query();
        $search = $request->input('query','');
        $page = $request->input('page',0);
        $page_size = 20;
        $sort = $request->input('sort','');

        if($search){
            $query->where('name','like','%'.$search.'%');
        }
        match($sort){
            'name_asc'  => $query->orderBy('name','asc'),
            'name_desc' => $query->orderBy('name','desc'),
            default     => $query,
        };
        //PAGINATE
        $query->take($page_size)->skip(($page-1) * $page_size);


        $count = $query->count();
        $items = $query->get();
        return [ 'count' => $count, 'items' => $items ];
    }
    public function list(Request $request){
        return CourseModel::orderBy('name','asc')->get();
    }
    public function update(Request $request,$uuid){
        $request->validate(['name'       =>'required|max:100',
                            'description'=>'max:1024',
                            'price'      =>'required|numeric',
                            'price_sale' =>'required|numeric',
                            'on_sale'    =>'required|boolean']);
        $record = CourseModel::where('uuid',$uuid)->firstOrFail();
        $price_computed = $request->input('on_sale') ? $request->input('price_sale') : $request->input('price');
        DB::beginTransaction();
        $res = $record->update([...$request->all(),
                                'price_computed' => $price_computed]);
        CourseUpdated::dispatch($record);
        DB::commit();
        return $res;
    }
    public function destroy(Request $request,$uuid){
        return CourseModel::where('uuid',$uuid)->firstOrFail()->delete();
    }
    //
    private function updatePrice(CourseModel $course){
        $price = $course->on_sale ? $course->price_sale : $course->price ;
        $course->update(['price_computed' => $price]);
    }

}

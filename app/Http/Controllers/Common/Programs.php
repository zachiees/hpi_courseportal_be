<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use App\Models\Program as ProgramModel;
use App\Models\ProgramCategory;
use App\Models\ProgramCategoryPivot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Programs extends Controller
{
    //
    public function find(Request $request,$uuid){
        return ProgramModel::where('uuid',$uuid)->with(['categories'])->firstOrFail();
    }
    public function index(Request $request){
        $page = $request->input('page', 1);
        $page_size = 20;
        $search = $request->input('query','');
        $sort = $request->input('sort','date_desc');

        $query= ProgramModel::query();
        if($search){
            $query->where('name','like','%'.$search.'%');
        }

        //SORT
        match ($sort) {
            'name_asc'  => $query->orderBy('name','asc'),
            'name_desc' => $query->orderBy('name','desc'),
            'date_asc'  => $query->orderBy('created_at','asc'),
            'date_desc' => $query->orderBy('created_at','desc'),
            default => $query,
        };
        $count = $query->count();
        //PAGINATE
        $items = $query->take($page_size)
                        ->skip(($page-1)*$page_size)
                        ->get();
        return ['count'=>$count,'items'=>$items];
    }
    public function store(Request $request){

        $request->validate(['name'       =>'required',
                            'description'=>'nullable',
                            'on_sale'    =>'required|boolean',
                            'price'      =>'required|numeric|min:0',
                            'price_sale' =>'required|numeric|min:0',

                            'pricing_type' =>'required|in:total,custom']);
        //
        $categories =  $request->input('category',[]);
        DB::beginTransaction();
        $res = ProgramModel::create($request->all());
        foreach($categories as $uuid){
            $cat = ProgramCategory::where('uuid',$uuid)->first();
            if(!$cat){continue;}
            ProgramCategoryPivot::create(['category_id'=> $cat->id,
                                          'program_id'=> $res->id]);
        }
        DB::commit();
        return $res;
    }
    public function update(Request $request,$uuid){
        $record = ProgramModel::where('uuid',$uuid)->firstOrFail();

        $request->validate(['name'       =>'required',
                            'description'=>'nullable',
                            'on_sale'    =>'required|boolean',
                            'price'      =>'required|numeric|min:0',
                            'price_sale' =>'required|numeric|min:0',
                            'pricing_type' =>'required|in:total,custom']);
        $categories =  $request->input('category',[]);

        DB::beginTransaction();
        $res = $record->update($request->all());
        ProgramCategoryPivot::where('program_id',$record->id)->delete();
        foreach($categories as $uuid){
            $cat = ProgramCategory::where('uuid',$uuid)->first();
            if(!$cat){continue;}
            ProgramCategoryPivot::create(['category_id'=> $cat->id,
                                          'program_id' => $record->id]);
        }
        DB::commit();
        return $res;

    }
    public function index_categories(Request $request){
        $page = $request->input('page', 1);
        $page_size = 20;
        $search = $request->input('query','');

        $query=ProgramCategory::query()->withCount('programs');
        if($search){
            $query->where('name','like','%'.$search.'%');
        }
        $count = $query->count();
        //PAGINATE
        $items = $query->take($page_size)
            ->skip(($page-1)*$page_size)
            ->get();
        return ['count'=>$count,'items'=>$items];
    }
    public function store_categories(Request $request){
        $request->validate(['name'=>'required|string|max:100|unique:program_categories,name']);
        return ProgramCategory::create($request->all());
    }
    public function update_categories(Request $request,$uuid){
        $record = ProgramCategory::where('uuid',$uuid)->firstOrFail();
        $request->validate(['name'=> ['required','string','max:100',Rule::unique('program_categories','name')->ignore($record)]]);
        return $record->update($request->all());
    }
    public function destroy_categories(Request $request,$uuid){
        return ProgramCategory::where('uuid',$uuid)->firstOrFail()->delete();
    }

}

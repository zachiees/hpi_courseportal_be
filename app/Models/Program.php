<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramCategoryPivot;

class Program extends Model
{   use HasUuids;
    //
    protected $hidden = ['id'];
    protected $fillable = ['name',
                           'description',
                           'pricing_type',
                           'price',
                           'price_sale',
                           'on_sale'];

    public function uniqueIds(){
        return ['uuid'];
    }
    //RELATIONS
    public function categories(){
        return $this->belongsToMany(ProgramCategory::class,ProgramCategoryPivot::class, 'program_id', 'category_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramCategoryPivot;
use App\Models\Course;
use App\Models\ProgramCourse;

class Program extends Model
{   use HasUuids;
    //
    protected $hidden = ['id'];
    protected $fillable = ['name',
                           'description',
                           'pricing_type',
                           'price',
                           'price_sale',
                           'price_computed',
                           'on_sale',
                           'img_thumbnail',
                           'img_cover'

    ];

    public function uniqueIds(){
        return ['uuid'];
    }
    //RELATIONS
    public function categories(){
        return $this->belongsToMany(ProgramCategory::class,ProgramCategoryPivot::class, 'program_id', 'category_id');
    }
    public function courses(){
        return $this->belongsToMany(Course::class,ProgramCourse::class, 'program_id', 'course_id');
    }

}

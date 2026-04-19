<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramCourse;
use App\Events\Course\CourseDestroyed;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{   use HasUuids;
    //

    protected $hidden = ['id'];
    protected $fillable = [ 'name',
                            'description',
                            'price',
                            'price_sale',
                            'price_computed',
                            'on_sale',
                            'lms_course_id',
                            'tags',
                            'img_cover',
                            'principal_id',
                            'img_thumbnail'];

    protected $casts = [
        'tags'=>'array',
    ];

    protected $dispatchesEvents = [
        'deleting' => CourseDestroyed::class
    ];

    public function uniqueIds(){
        return ['uuid'];
    }
    //ATTRIBUTES
    public function imgCover(): Attribute{
        return Attribute::make(
            get: fn ($url) => $url? Storage::url($url):null,
            set: fn ($value) => $value,
        );
    }
    public function imgThumbnail(): Attribute{
        return Attribute::make(
            get: fn ($url) => $url? Storage::url($url):null,
            set: fn ($value) => $value,
        );
    }
    //RELATIONS
    public function programs(){
        return $this->belongsToMany(Program::class,ProgramCourse::class,'course_id','program_id');
    }
    public function principal(){
        return $this->belongsTo(Principals::class,'principal_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramEnrollment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'program_id',
    ];

    //RELATIONS
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function program(){
        return $this->belongsTo(Program::class,'program_id');
    }
}

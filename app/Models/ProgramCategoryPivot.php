<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCategoryPivot extends Model
{
    //
    protected $table = "programs_categories_pivot";
    protected $hidden = ['id'];
    protected $fillable = ['category_id',
                           'program_id'];

}

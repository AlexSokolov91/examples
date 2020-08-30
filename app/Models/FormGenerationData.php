<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormGenerationData extends Model
{
    protected $fillable = [
        'form_id' , 'form_generation_id' ,'option'
    ];
}

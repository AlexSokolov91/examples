<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormGeneration extends Model
{
    public function data()
    {
        return $this->hasMany(FormGenerationData::class);
    }
}

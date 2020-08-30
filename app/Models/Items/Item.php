<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'created_at', 'updated_at'
        ];
    public function translations()
    {
        return $this->hasMany(ItemTranslation::class);
    }

    public function categories()
    {
        return $this->hasMany(ItemCategory::class);
    }


}

<?php

namespace App;

use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable = [
        'item_id', 'category_id'
    ];


    public function translation()
    {
        return $this->belongsTo(ItemTranslation::class);
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'category_id');
    }
}

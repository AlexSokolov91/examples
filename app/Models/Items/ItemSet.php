<?php

namespace App\Models\Items;


use App\Item;
use App\ItemTranslation;
use Illuminate\Database\Eloquent\Model;

class ItemSet extends Model
{
    protected $fillable = [
      'price_without_set'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}

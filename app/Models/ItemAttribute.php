<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
    protected $fillable = [
        'value', 'parent'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

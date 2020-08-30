<?php

namespace App;

use App\Models\Items\ItemSet;
use App\Models\ModelFile;
use App\Models\TaxonomyTranslate;
use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{
    protected $primaryKey = 'item_id';

    protected $fillable = [
      'item_id', 'name', 'description',
        'short_description', 'is_active', 'lang'
    ];

    public function hasImage(): bool
    {
        return (bool)$this->image_path;
    }

    public function getImageUrl(): string
    {
        return self::PUBLIC_IMAGE_DIR . $this->image_path;
    }

    public function imageExists(): bool
    {
        return Storage::exists(trim(self::STORAGE_IMAGE_DIR . $this->image_path, "app"));
    }

    public function categories()
    {
        return $this->hasMany(ItemCategory::class, 'item_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function files()
    {
        return $this->morphMany(ModelFile::class, 'model');
    }

    public function itemSet()
    {
        return $this->belongsTo(ItemSet::class);
    }


}

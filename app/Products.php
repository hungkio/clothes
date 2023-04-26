<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Products extends Model implements HasMedia
{
    protected $fillable = ['name', 'id_pos', 'parent', 'quantity', 'cut', 'receive', 'not_receive', 'note', 'size', 'brand_id', 'design_id', 'produce_id', 'produce_quantity', 'purchase_id'];
    use InteractsWithMedia;
    public $guarded = [];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->useFallbackUrl('/backend/global_assets/images/placeholders/placeholder.jpg');
        $this
            ->addMediaCollection('file')
            ->singleFile()
            ->useFallbackUrl('/backend/global_assets/images/placeholders/placeholder.jpg');
    }

    public function design()
    {
        return $this->belongsTo(Designs::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }

    public function parent()
    {
        return $this->belongsTo(Products::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Products::class, 'parent');
    }
}

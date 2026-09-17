<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_at_price',
        'image',
        'status',
        'is_featured',
        'stock',
        'colors',
        'sizes',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function getColorsListAttribute()
    {
        if ($this->relationLoaded('variants') || $this->variants()->exists()) {
            $variantColors = $this->variants->pluck('color')->filter()->unique()->values()->toArray();
            if (!empty($variantColors)) {
                return $variantColors;
            }
        }
        if (empty($this->colors)) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode(',', $this->colors))));
    }

    public function getSizesListAttribute()
    {
        if ($this->relationLoaded('variants') || $this->variants()->exists()) {
            $variantSizes = $this->variants->pluck('size')->filter()->unique()->values()->toArray();
            if (!empty($variantSizes)) {
                return $variantSizes;
            }
        }
        if (empty($this->sizes)) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode(',', $this->sizes))));
    }

    public function getMinPriceAttribute()
    {
        if ($this->variants && $this->variants->count() > 0) {
            return $this->variants->min('price');
        }
        return $this->price;
    }

    public function getMaxPriceAttribute()
    {
        if ($this->variants && $this->variants->count() > 0) {
            return $this->variants->max('price');
        }
        return $this->price;
    }
}

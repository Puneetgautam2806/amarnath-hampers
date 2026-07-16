<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $fillable = [
        'image_path',
        'subtitle',
        'title',
        'description',
        'btn1_text',
        'btn1_link',
        'btn2_text',
        'btn2_link',
        'orders',
        'status',
    ];

    /**
     * Scope to only include active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

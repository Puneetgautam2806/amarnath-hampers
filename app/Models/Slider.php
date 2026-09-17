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
        'btn1_style',
        'btn1_bg_color',
        'btn1_text_color',
        'btn2_text',
        'btn2_link',
        'btn2_style',
        'btn2_bg_color',
        'btn2_text_color',
        'content_position',
        'text_align',
        'overlay_opacity',
        'title_color',
        'subtitle_color',
        'subtitle_bg',
        'description_color',
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

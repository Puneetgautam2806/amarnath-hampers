<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'featured_image', 'author_name', 'status', 'published_at'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];
}

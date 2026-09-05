<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'logo_path',
        'favicon_path',
        'phone',
        'whatsapp',
        'email',
        'address',
        'working_hours',
        'map_embed_url',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'footer_desc',
        'copyright_text',
    ];
}

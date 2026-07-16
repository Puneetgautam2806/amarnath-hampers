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
        'email',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'footer_desc',
        'copyright_text',
    ];
}

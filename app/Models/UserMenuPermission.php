<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenuPermission extends Model
{
    protected $fillable = [
        'user_id',
        'linktbl_id',
        'is_allowed',
    ];
}

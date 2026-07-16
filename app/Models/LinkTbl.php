<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserMenuPermission;

class LinkTbl extends Model
{
    protected $table = 'linktbls';
    protected $fillable = ['menu_name', 'path', 'parent_id', 'status', 'category', 'is_parent', 'orders', 'icon', 'permissions'];

    public function userPermissions()
    {
        return $this->hasMany(UserMenuPermission::class, 'linktbl_id');
    }
}

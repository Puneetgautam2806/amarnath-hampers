<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LinkTbl;
use Illuminate\Support\Facades\File;

class LinktblSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(path: 'database/json/menu.json');
        $menu = collect(json_decode($json));

        $menu->each(function ($item) {
            LinkTbl::query()->updateOrCreate([
                'path' => $item->path,
                'parent_id' => $item->parent_id,
            ], [
                "menu_name" => $item->menu_name,
                "status" => $item->status,
                "category" => $item->category,
                "is_parent" => $item->is_parent,
                "orders" => $item->orders,
                "icon" => $item->icon,
                "permissions" => $item->permissions ?? 'admin,manager,staff'
            ]);
        });
    }
}

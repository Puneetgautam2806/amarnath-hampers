<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE `sliders` MODIFY `title` VARCHAR(255) NULL");
        } catch (\Throwable $e) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->string('title')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE `sliders` MODIFY `title` VARCHAR(255) NOT NULL");
        } catch (\Throwable $e) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->string('title')->nullable(false)->change();
            });
        }
    }
};

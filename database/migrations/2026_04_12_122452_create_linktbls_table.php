<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('linktbls', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name', 250);
            $table->string('path', 500);
            $table->integer('parent_id');
            $table->tinyInteger('status');
            $table->string('category', 250);
            $table->tinyInteger('is_parent')->default(2);
            $table->integer('orders');
            $table->string('icon', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linktbls');
    }
};

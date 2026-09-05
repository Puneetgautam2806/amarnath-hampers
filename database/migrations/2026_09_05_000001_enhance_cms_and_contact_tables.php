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
        // Add extra dynamic fields to site_settings table
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('site_settings', 'working_hours')) {
                $table->string('working_hours')->nullable()->after('address');
            }
            if (!Schema::hasColumn('site_settings', 'map_embed_url')) {
                $table->text('map_embed_url')->nullable()->after('working_hours');
            }
        });

        // Add designation to testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'designation')) {
                $table->string('designation')->nullable()->after('name');
            }
        });

        // Create contact_messages table for customer inquiries
        if (!Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp', 'working_hours', 'map_embed_url']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['designation']);
        });

        Schema::dropIfExists('contact_messages');
    }
};

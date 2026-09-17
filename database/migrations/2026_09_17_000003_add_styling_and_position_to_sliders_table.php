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
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'content_position')) {
                $table->string('content_position', 30)->default('left')->after('status');
            }
            if (!Schema::hasColumn('sliders', 'text_align')) {
                $table->string('text_align', 30)->default('left')->after('content_position');
            }
            if (!Schema::hasColumn('sliders', 'overlay_opacity')) {
                $table->integer('overlay_opacity')->default(0)->after('text_align');
            }
            if (!Schema::hasColumn('sliders', 'title_color')) {
                $table->string('title_color', 30)->nullable()->after('overlay_opacity');
            }
            if (!Schema::hasColumn('sliders', 'subtitle_color')) {
                $table->string('subtitle_color', 30)->nullable()->after('title_color');
            }
            if (!Schema::hasColumn('sliders', 'subtitle_bg')) {
                $table->string('subtitle_bg', 30)->nullable()->after('subtitle_color');
            }
            if (!Schema::hasColumn('sliders', 'description_color')) {
                $table->string('description_color', 30)->nullable()->after('subtitle_bg');
            }
            if (!Schema::hasColumn('sliders', 'btn1_style')) {
                $table->string('btn1_style', 50)->nullable()->after('btn1_link');
            }
            if (!Schema::hasColumn('sliders', 'btn1_bg_color')) {
                $table->string('btn1_bg_color', 30)->nullable()->after('btn1_style');
            }
            if (!Schema::hasColumn('sliders', 'btn1_text_color')) {
                $table->string('btn1_text_color', 30)->nullable()->after('btn1_bg_color');
            }
            if (!Schema::hasColumn('sliders', 'btn2_style')) {
                $table->string('btn2_style', 50)->nullable()->after('btn2_link');
            }
            if (!Schema::hasColumn('sliders', 'btn2_bg_color')) {
                $table->string('btn2_bg_color', 30)->nullable()->after('btn2_style');
            }
            if (!Schema::hasColumn('sliders', 'btn2_text_color')) {
                $table->string('btn2_text_color', 30)->nullable()->after('btn2_bg_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn([
                'content_position',
                'text_align',
                'overlay_opacity',
                'title_color',
                'subtitle_color',
                'subtitle_bg',
                'description_color',
                'btn1_style',
                'btn1_bg_color',
                'btn1_text_color',
                'btn2_style',
                'btn2_bg_color',
                'btn2_text_color',
            ]);
        });
    }
};

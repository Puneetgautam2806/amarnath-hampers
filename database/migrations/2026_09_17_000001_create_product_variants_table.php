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
        if (!Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('color')->nullable();
                $table->string('size')->nullable();
                $table->string('sku')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('compare_at_price', 10, 2)->nullable();
                $table->integer('stock')->default(10);
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'variant_id')) {
                $table->foreignId('variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();
            }
            if (!Schema::hasColumn('order_items', 'variant_image')) {
                $table->string('variant_image')->nullable()->after('size');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'variant_id')) {
                $table->dropConstrainedForeignId('variant_id');
            }
            if (Schema::hasColumn('order_items', 'variant_image')) {
                $table->dropColumn('variant_image');
            }
        });

        Schema::dropIfExists('product_variants');
    }
};

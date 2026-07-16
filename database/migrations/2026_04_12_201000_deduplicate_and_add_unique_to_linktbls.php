<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove duplicate menus keeping the oldest row for the same logical key.
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DELETE FROM linktbls WHERE id NOT IN (SELECT MIN(id) FROM linktbls GROUP BY path, parent_id)');
        } else {
            DB::statement('DELETE t1 FROM linktbls t1 INNER JOIN linktbls t2 WHERE t1.id > t2.id AND t1.path = t2.path AND t1.parent_id = t2.parent_id');
        }

        Schema::table('linktbls', function (Blueprint $table) {
            $table->unique(['path', 'parent_id'], 'linktbls_path_parent_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linktbls', function (Blueprint $table) {
            $table->dropUnique('linktbls_path_parent_unique');
        });
    }
};

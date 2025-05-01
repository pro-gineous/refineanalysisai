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
        Schema::table('frameworks', function (Blueprint $table) {
            // Agregar los nuevos campos si no existen
            if (!Schema::hasColumn('frameworks', 'short_description')) {
                $table->string('short_description')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('frameworks', 'comprehensive_description')) {
                $table->text('comprehensive_description')->nullable()->after('short_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frameworks', function (Blueprint $table) {
            // Eliminar los campos si existen
            if (Schema::hasColumn('frameworks', 'short_description')) {
                $table->dropColumn('short_description');
            }
            
            if (Schema::hasColumn('frameworks', 'comprehensive_description')) {
                $table->dropColumn('comprehensive_description');
            }
        });
    }
};

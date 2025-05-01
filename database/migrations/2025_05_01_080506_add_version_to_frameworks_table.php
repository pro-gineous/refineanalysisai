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
            $table->string('version')->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('version');
            $table->integer('projects_count')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frameworks', function (Blueprint $table) {
            $table->dropColumn(['version', 'is_active', 'projects_count']);
        });
    }
};

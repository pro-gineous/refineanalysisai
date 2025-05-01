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
        Schema::table('settings', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de agregarlas
            if (!Schema::hasColumn('settings', 'type')) {
                $table->string('type')->default('text')->after('value');
            }
            
            if (!Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('value');
            }
            
            if (!Schema::hasColumn('settings', 'name')) {
                $table->string('name')->nullable()->after('type');
            }
            
            if (!Schema::hasColumn('settings', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('settings', 'is_public')) {
                $table->boolean('is_public')->default(false)->after('description');
            }
            
            if (!Schema::hasColumn('settings', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_public');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Eliminar columnas añadidas si existen
            $columns = ['type', 'group', 'name', 'description', 'is_public', 'sort_order'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

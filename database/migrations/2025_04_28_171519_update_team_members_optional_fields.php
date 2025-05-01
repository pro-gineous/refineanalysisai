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
        Schema::table('team_members', function (Blueprint $table) {
            // جعل حقول الاسم والبريد الإلكتروني والدور اختيارية
            if (Schema::hasColumn('team_members', 'name')) {
                $table->string('name')->nullable()->change();
            }
            
            if (Schema::hasColumn('team_members', 'email')) {
                $table->string('email')->nullable()->change();
                // إزالة قيد التفرد (unique) من حقل البريد الإلكتروني
                $table->dropUnique(['email']);
            }
            
            if (Schema::hasColumn('team_members', 'role')) {
                $table->string('role')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            //
        });
    }
};

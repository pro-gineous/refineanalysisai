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
        if (!Schema::hasTable('team_members')) {
            Schema::create('team_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('team_member_id')->constrained('users')->onDelete('cascade');
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        } else {
            Schema::table('team_members', function (Blueprint $table) {
                if (!Schema::hasColumn('team_members', 'status')) {
                    $table->string('status')->default('pending');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('team_members')) {
            Schema::dropIfExists('team_members');
        }
    }
};

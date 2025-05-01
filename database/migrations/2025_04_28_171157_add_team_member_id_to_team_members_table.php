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
            if (!Schema::hasColumn('team_members', 'team_member_id')) {
                $table->unsignedBigInteger('team_member_id')->nullable()->after('user_id');
                $table->foreign('team_member_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('team_members', 'status')) {
                $table->string('status')->default('pending')->after('team_member_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            if (Schema::hasColumn('team_members', 'team_member_id')) {
                $table->dropForeign(['team_member_id']);
                $table->dropColumn('team_member_id');
            }
            
            if (Schema::hasColumn('team_members', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};

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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('project_updates')->default(true);
            $table->boolean('task_assignments')->default(true);
            $table->boolean('comments')->default(true);
            $table->boolean('mentions')->default(true);
            $table->boolean('deadlines')->default(true);
            $table->boolean('team_invitations')->default(true);
            $table->timestamps();
            
            // إضافة فهرس للسرعة
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};

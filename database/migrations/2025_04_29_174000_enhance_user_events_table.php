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
        if (!Schema::hasTable('user_events')) {
            Schema::create('user_events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('event_type');
                $table->string('event_name');
                $table->string('page')->nullable();
                $table->string('section')->nullable();
                $table->string('action')->nullable();
                $table->json('metadata')->nullable();
                $table->string('session_id')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('device_type')->nullable();
                $table->string('browser')->nullable();
                $table->string('os')->nullable();
                $table->timestamp('event_time');
                $table->timestamps();
                
                // Add indexes for better query performance
                $table->index('event_type');
                $table->index('event_time');
                $table->index(['user_id', 'event_time']);
            });
        } else {
            // Make sure all needed columns exist
            Schema::table('user_events', function (Blueprint $table) {
                if (!Schema::hasColumn('user_events', 'event_time')) {
                    $table->timestamp('event_time')->nullable();
                }
                if (!Schema::hasColumn('user_events', 'device_type')) {
                    $table->string('device_type')->nullable();
                }
                if (!Schema::hasColumn('user_events', 'browser')) {
                    $table->string('browser')->nullable();
                }
                if (!Schema::hasColumn('user_events', 'os')) {
                    $table->string('os')->nullable();
                }
                if (!Schema::hasColumn('user_events', 'section')) {
                    $table->string('section')->nullable();
                }
                
                // Add indexes if they don't exist
                if (!Schema::hasIndex('user_events', 'event_type')) {
                    $table->index('event_type');
                }
                if (!Schema::hasIndex('user_events', 'event_time')) {
                    $table->index('event_time');
                }
                if (!Schema::hasIndex('user_events', ['user_id', 'event_time'])) {
                    $table->index(['user_id', 'event_time']);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't drop the table in down() to prevent data loss
    }
};

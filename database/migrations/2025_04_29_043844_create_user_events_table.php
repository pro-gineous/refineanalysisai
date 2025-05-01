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
        Schema::create('user_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('event_type'); // login, view, create, update, click, etc.
            $table->string('event_name');
            $table->string('page')->nullable();
            $table->string('section')->nullable();
            $table->string('action')->nullable();
            $table->json('metadata')->nullable(); // Additional event data as JSON
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->timestamp('event_time')->useCurrent();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('user_id');
            $table->index('event_type');
            $table->index('event_time');
            $table->index('session_id');
            $table->index('device_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_events');
    }
};

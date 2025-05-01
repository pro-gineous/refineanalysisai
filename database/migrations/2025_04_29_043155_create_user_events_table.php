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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('event_type'); // login, view_project, create_idea, etc.
            $table->string('event_name');
            $table->string('page')->nullable(); // where the event occurred
            $table->string('section')->nullable(); // specific section on the page
            $table->string('action')->nullable(); // specific action taken by user
            $table->json('metadata')->nullable(); // additional event data
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->timestamp('event_time'); // exact time of event
            $table->timestamps();
            
            // Indexes for faster analytics queries
            $table->index(['user_id', 'event_type']);
            $table->index('event_time');
            $table->index('page');
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

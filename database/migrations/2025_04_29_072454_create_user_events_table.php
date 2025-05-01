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
            $table->string('event_type')->nullable();
            $table->string('event_name')->nullable();
            $table->timestamp('event_time')->nullable();
            $table->string('page')->nullable();
            $table->string('section')->nullable();
            $table->string('action')->nullable();
            $table->json('metadata')->nullable();
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->timestamps();
            
            // Índices para mejorar el rendimiento de las consultas
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

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
        Schema::create('login_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('device_type', 50)->nullable(); // Desktop, Mobile, Tablet
            $table->string('operating_system', 100)->nullable();
            $table->string('browser', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('geo_location', 100)->nullable();
            $table->dateTime('login_at')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas eficientes
            $table->index('user_id');
            $table->index('login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_history');
    }
};

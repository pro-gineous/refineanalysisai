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
        Schema::create('ai_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('request_type')->nullable()->comment('Type of AI request (idea_generation, project_analysis, etc)');
            $table->string('model')->comment('The AI model used');
            $table->integer('tokens_input')->default(0)->comment('Number of input tokens used');
            $table->integer('tokens_output')->default(0)->comment('Number of output tokens generated');
            $table->integer('total_tokens')->default(0)->comment('Total tokens used');
            $table->decimal('estimated_cost', 10, 6)->default(0)->comment('Estimated cost in USD');
            $table->text('prompt')->nullable()->comment('The input prompt (optional for privacy)');
            $table->text('response')->nullable()->comment('The response from AI (optional for privacy)');
            $table->json('metadata')->nullable()->comment('Additional details about the request');
            $table->boolean('success')->default(true)->comment('Whether the request was successful');
            $table->string('error_message')->nullable()->comment('Error message if request failed');
            $table->string('ip_address')->nullable()->comment('IP address of the requester');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_requests');
    }
};

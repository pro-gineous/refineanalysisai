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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index();
            $table->string('key')->index();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            // Composite unique key for group and key combination
            $table->unique(['group', 'key']);
        });

        // Insert default AI settings
        DB::table('settings')->insert([
            [
                'group' => 'ai',
                'key' => 'openai_api_key',
                'value' => '',
                'description' => 'Your OpenAI API key for AI features',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'ai',
                'key' => 'default_model',
                'value' => 'gpt-4o',
                'description' => 'Default OpenAI model to use',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'ai',
                'key' => 'temperature',
                'value' => '0.7',
                'description' => 'Temperature setting for AI responses (0.0-1.0)',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'ai',
                'key' => 'max_tokens',
                'value' => '2048',
                'description' => 'Maximum tokens for AI responses',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'ai',
                'key' => 'enable_ai_journey',
                'value' => '1',
                'description' => 'Enable AI-assisted journey feature',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'ai',
                'key' => 'enable_idea_generation',
                'value' => '1',
                'description' => 'Enable AI-powered idea generation',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

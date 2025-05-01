<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Log;
use OpenAI\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $model;
    protected $maxTokens;
    protected $temperature;

    public function __construct()
    {
        $this->apiKey = config('openai.api_key', env('OPENAI_API_KEY', ''));
        $this->model = config('openai.model', 'gpt-4o');
        $this->maxTokens = config('openai.max_tokens', 2048);
        $this->temperature = config('openai.temperature', 0.7);

        $this->client = OpenAI::client($this->apiKey);
    }

    /**
     * Generate a response using OpenAI GPT model
     *
     * @param string $prompt The prompt to send to OpenAI
     * @param array $options Additional options for the request
     * @return string The generated response
     */
    public function generateResponse(string $prompt, array $options = []): string
    {
        try {
            $response = $this->client->chat()->create([
                'model' => $options['model'] ?? $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $options['system_message'] ?? 'You are a helpful assistant for our project management platform.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $options['max_tokens'] ?? $this->maxTokens,
                'temperature' => $options['temperature'] ?? $this->temperature,
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return 'Sorry, I encountered an error while processing your request. Please try again later.';
        }
    }

    /**
     * Generate ideas based on a given topic or project description
     *
     * @param string $description Description of the project or topic
     * @return array List of generated ideas
     */
    public function generateIdeas(string $description): array
    {
        $prompt = "Generate 5 creative ideas related to the following project or topic: \"{$description}\". Provide each idea with a title and a brief description.";
        
        $systemMessage = "You are a creative assistant that helps users brainstorm innovative ideas for their projects. Be specific, practical, and think outside the box.";
        
        $response = $this->generateResponse($prompt, [
            'system_message' => $systemMessage,
            'temperature' => 0.9, // Higher temperature for more creativity
        ]);
        
        // Parse the response into structured ideas
        $ideas = $this->parseIdeasResponse($response);
        
        return $ideas;
    }

    /**
     * Parse the AI response into structured ideas
     *
     * @param string $response The raw AI response
     * @return array The structured ideas
     */
    protected function parseIdeasResponse(string $response): array
    {
        $ideas = [];
        
        // Simple parsing - assumes responses are numbered 1-5
        preg_match_all('/(\d+\.\s*.*?)(?=\d+\.|$)/s', $response, $matches);
        
        if (!empty($matches[0])) {
            foreach ($matches[0] as $ideaText) {
                // Extract title and description
                if (preg_match('/(?:\d+\.\s*)(.*?)(?:\n|:)(.*)/s', $ideaText, $parts)) {
                    $title = trim($parts[1]);
                    $description = trim($parts[2]);
                    
                    $ideas[] = [
                        'title' => $title,
                        'description' => $description
                    ];
                }
            }
        }
        
        // If parsing failed, return the whole response as a single idea
        if (empty($ideas)) {
            $ideas[] = [
                'title' => 'Generated Idea',
                'description' => $response
            ];
        }
        
        return $ideas;
    }

    /**
     * Analyze a project and provide recommendations
     *
     * @param array $project The project data to analyze
     * @return array Analysis and recommendations
     */
    public function analyzeProject(array $project): array
    {
        $projectInfo = "Project Title: {$project['title']}\n";
        $projectInfo .= "Description: {$project['description']}\n";
        $projectInfo .= "Status: {$project['status']}\n";
        $projectInfo .= "Timeline: {$project['start_date']} to {$project['end_date']}\n";
        
        $prompt = "Analyze the following project and provide:\n" .
                 "1. Strengths of the project\n" .
                 "2. Potential risks or challenges\n" .
                 "3. Three specific recommendations for improvement\n\n" .
                 $projectInfo;
                 
        $systemMessage = "You are an expert project analyst who helps identify strengths, weaknesses, and opportunities for improvement in projects. Be specific, practical, and actionable in your analysis.";
        
        $response = $this->generateResponse($prompt, [
            'system_message' => $systemMessage,
        ]);
        
        return [
            'analysis' => $response,
            'project_id' => $project['id'] ?? null,
        ];
    }
}

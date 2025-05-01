<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Project;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AIAssistantController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
        $this->middleware('auth');
    }

    /**
     * Display the AI assistant view
     */
    public function index()
    {
        return view('user.ai_assistant');
    }

    /**
     * Process a general chat message to the AI assistant
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $response = $this->openAIService->generateResponse(
                $request->message,
                [
                    'system_message' => 'You are a helpful assistant for a project management platform. Help the user with their projects, ideas, and tasks. Keep responses concise and practical.'
                ]
            );

            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('AI Assistant Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Generate new project ideas
     */
    public function generateIdeas(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:500',
        ]);

        try {
            $ideas = $this->openAIService->generateIdeas($request->description);
            
            return response()->json([
                'success' => true,
                'ideas' => $ideas
            ]);
        } catch (\Exception $e) {
            Log::error('AI Idea Generation Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate ideas. Please try again later.'
            ], 500);
        }
    }

    /**
     * Save a generated idea to the database
     */
    public function saveIdea(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $idea = new Idea();
            $idea->title = $request->title;
            $idea->description = $request->description;
            $idea->owner_id = Auth::id();
            $idea->status = 'active';
            $idea->save();
            
            return response()->json([
                'success' => true,
                'idea' => $idea,
                'message' => 'Idea saved successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('AI Idea Saving Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save idea. Please try again.'
            ], 500);
        }
    }

    /**
     * Analyze an existing project and provide recommendations
     */
    public function analyzeProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        try {
            $project = Project::findOrFail($request->project_id);
            
            // Check if the user owns this project
            if ($project->owner_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to analyze this project.'
                ], 403);
            }
            
            $analysis = $this->openAIService->analyzeProject($project->toArray());
            
            return response()->json([
                'success' => true,
                'analysis' => $analysis
            ]);
        } catch (\Exception $e) {
            Log::error('AI Project Analysis Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to analyze project. Please try again later.'
            ], 500);
        }
    }
}

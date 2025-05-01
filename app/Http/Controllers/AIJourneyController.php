<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AIJourneyController extends Controller
{
    /**
     * Display the AI Journey start page for ideas
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function startIdeaJourney(Request $request)
    {
        return view('user.ai-journey.idea-start', [
            'frameworkId' => $request->input('framework_id'),
            'journeyType' => 'idea'
        ]);
    }

    /**
     * Display the AI Journey start page for projects
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function startProjectJourney(Request $request)
    {
        return view('user.ai-journey.project-start', [
            'frameworkId' => $request->input('framework_id'),
            'journeyType' => 'project'
        ]);
    }

    /**
     * Process data gathering stage for AI Journey
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processDataGathering(Request $request)
    {
        $journeyType = $request->input('journey_type', 'project');
        $frameworkId = $request->input('framework_id');
        
        // Handle file uploads if present
        $uploadedFiles = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('journey-documents', 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'path' => $path,
                ];
            }
        }
        
        // Store data in session for the journey
        $journeyData = [
            'type' => $journeyType,
            'framework_id' => $frameworkId,
            'uploaded_files' => $uploadedFiles,
            'start_time' => now()->toString(),
            'messages' => [],
        ];
        
        session(['ai_journey' => $journeyData]);
        
        return view('user.ai-journey.data-gathering', [
            'journeyType' => $journeyType,
            'files' => $uploadedFiles,
        ]);
    }

    /**
     * Display the AI Journey progress page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showJourneyProgress(Request $request)
    {
        $journeyData = session('ai_journey', []);
        $journeyType = $journeyData['type'] ?? 'project';
        
        // Placeholder data for progress visualization
        $progress = [
            'percentage' => 75,
            'current_stage' => 3,
            'total_stages' => 5,
            'completed_tasks' => 6,
            'total_tasks' => 8,
        ];
        
        return view('user.ai-journey.progress', [
            'journeyType' => $journeyType,
            'journeyData' => $journeyData,
            'progress' => $progress,
        ]);
    }
    
    /**
     * Process AI chat message and get a response
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processChatMessage(Request $request)
    {
        $openAI = new OpenAIService();
        $message = $request->input('message');
        $journeyData = session('ai_journey', []);
        $journeyType = $journeyData['type'] ?? 'project';
        
        // Add user message to journey history
        $journeyData['messages'][] = [
            'role' => 'user',
            'content' => $message,
            'timestamp' => now()->toString(),
        ];
        
        // Determine what system prompt to use based on journey type and stage
        $systemPrompt = $this->getSystemPrompt($journeyType, $journeyData);
        
        // Generate AI response
        try {
            $response = $openAI->generateResponse($message, [
                'system_message' => $systemPrompt,
                'temperature' => 0.7,
            ]);
            
            // Add AI response to journey history
            $journeyData['messages'][] = [
                'role' => 'assistant',
                'content' => $response,
                'timestamp' => now()->toString(),
            ];
            
            // Update journey progress based on the conversation
            $journeyData['current_stage'] = $journeyData['current_stage'] ?? 1;
            $journeyData['progress'] = $journeyData['progress'] ?? 10;
            
            // Update session data
            session(['ai_journey' => $journeyData]);
            
            return response()->json([
                'success' => true,
                'message' => $response,
                'progress' => $journeyData['progress'],
            ]);
        } catch (\Exception $e) {
            Log::error('OpenAI Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get the appropriate system prompt based on journey type and stage
     * 
     * @param string $journeyType
     * @param array $journeyData
     * @return string
     */
    private function getSystemPrompt(string $journeyType, array $journeyData): string
    {
        if ($journeyType === 'idea') {
            return "You are an AI assistant helping with idea development. Ask questions to understand the user's idea, "
                . "such as the problem it solves, target audience, potential features, and unique selling points. "
                . "Be encouraging, insightful, and help refine the idea through your questions.";
        } else {
            return "You are an AI project management assistant. Ask questions to understand the user's project needs, "
                . "such as objectives, timeline, resources, stakeholders, and constraints. "
                . "Help them refine their project plan by asking specific, relevant questions. "
                . "You're an expert in all project management frameworks and methodologies.";
        }
    }
}

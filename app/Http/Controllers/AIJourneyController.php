<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\AIRequest;

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
     * Process AI chat message and get a response with enhanced functionality
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processChatMessage(Request $request)
    {
        try {
            // 1. Validate and get input
            $request->validate([
                'message' => 'required|string|max:4000',
            ]);
            
            $message = $request->input('message');
            $journeyData = session('ai_journey', []);
            $journeyType = $journeyData['type'] ?? 'project';
            
            // 2. Add user message to journey history
            $journeyData['messages'] = $journeyData['messages'] ?? [];
            $journeyData['messages'][] = [
                'role' => 'user',
                'content' => $message,
                'timestamp' => now()->toString(),
            ];
            
            // 3. Get system prompt 
            $systemPrompt = $this->getSystemPrompt($journeyType, $journeyData);
            
            // 4. Simple direct call to OpenAI - basic approach to fix immediate issue
            Log::info('Making AI Journey chat request', [
                'message_length' => strlen($message),
                'journey_type' => $journeyType
            ]);
            
            // Create a fresh instance of OpenAIService
            $openAI = new OpenAIService();
            
            // Make a basic API call with minimal options
            $response = $openAI->generateResponse($message, [
                'system_message' => $systemPrompt,
                'request_type' => 'ai_journey'
            ]);
            
            // 5. Process successful response
            // Add AI response to journey history
            $journeyData['messages'][] = [
                'role' => 'assistant',
                'content' => $response,
                'timestamp' => now()->toString(),
            ];
            
            // Update journey progress
            $currentProgress = $journeyData['progress'] ?? 0;
            $journeyData['progress'] = min(95, $currentProgress + 10);
            $journeyData['current_stage'] = $journeyData['current_stage'] ?? 1;
            
            // 6. Save updated journey data
            session(['ai_journey' => $journeyData]);
            
            // 7. Return success response
            return response()->json([
                'success' => true,
                'message' => $response,
                'progress' => $journeyData['progress']
            ]);
            
        } catch (\Exception $e) {
            // Log detailed error
            Log::error('AI Journey Error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return user-friendly error
            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error connecting to the AI service. Please try again.',
                'error' => 'api_error'
            ], 500);
        }
    }
    
    /**
     * Analyze AI response for journey progress indicators
     * 
     * @param string $response The AI response text
     * @param array &$journeyData Journey data to update
     * @return void
     */
    protected function analyzeResponseForJourneyProgress(string $response, array &$journeyData): void
    {
        // Keywords that might indicate completion of a stage
        $completionKeywords = [
            'next step', 'moving on', 'proceed to', 'let\'s summarize', 
            'now that we have', 'we\'ve completed', 'you\'ve finished'
        ];
        
        // Check if response contains completion indicators
        foreach ($completionKeywords as $keyword) {
            if (stripos($response, $keyword) !== false) {
                // Advance stage if keyword found and not already at final stage
                if (!isset($journeyData['current_stage']) || $journeyData['current_stage'] < 5) {
                    $journeyData['current_stage'] = ($journeyData['current_stage'] ?? 1) + 1;
                    $journeyData['stage_completed'][] = ($journeyData['current_stage'] - 1);
                    break;
                }
            }
        }
        
        // Extract potential next steps or action items from the response
        if (preg_match_all('/(?:next steps?|to proceed|should|could)(?:\s+\w+){1,5}\s+(?:try|do|create|implement|consider|think about|explore|analyze)\s+([^.!?]+)[.!?]/i', $response, $matches)) {
            $journeyData['next_steps'] = array_slice($matches[1], 0, 3); // Get top 3 next steps
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

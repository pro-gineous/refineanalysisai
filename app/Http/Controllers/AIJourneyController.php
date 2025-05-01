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
    /**
     * Process AI chat message and get a direct response from OpenAI API
     * This implementation bypasses the service layer for more direct and reliable API access
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processChatMessage(Request $request)
    {
        // Log inicio de la solicitud para seguimiento
        Log::info('========== INICIO SOLICITUD DE CHAT AI ==========');
        
        // Registrar que estamos usando API directa desde .env si el header está presente
        if ($request->header('X-Direct-API')) {
            Log::info('Solicitud marcada para uso directo de API desde .env');
        }
        
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
            
            // 4. Enhanced direct call to OpenAI with detailed logging
            Log::info('Making AI Journey chat request', [
                'message_length' => strlen($message),
                'journey_type' => $journeyType,
                'api_key_available' => !empty(env('OPENAI_API_KEY')),
                'model_requested' => env('OPENAI_MODEL', 'gpt-3.5-turbo')
            ]);
            
            // 5. USAMOS DIRECTAMENTE API KEY DE .ENV - Solución definitiva
            // Obtener la API key explicitamente del .env sin ningún fallback
            $apiKey = env('OPENAI_API_KEY');
            $model = env('OPENAI_MODEL', 'gpt-3.5-turbo');
            
            // Registrar uso de valores directos desde .env
            Log::info('Usando valores directamente de .env:', [
                'api_key_length' => strlen($apiKey),
                'model' => $model,
                'source' => '.env file'
            ]);
            
            // Validar que tengamos una clave API válida
            if (empty($apiKey) || strlen($apiKey) < 20) {
                throw new \Exception('OpenAI API Key is missing or invalid');
            }
            
            // Construir mensajes para la conversación con formato correcto
            $messages = [];
            
            // Mensaje del sistema
            if (!empty($systemPrompt)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemPrompt
                ];
            }
            
            // Mensajes previos (limitados a los últimos 5 para evitar superar límites)
            $recentMessages = array_slice($journeyData['messages'], -10);
            foreach ($recentMessages as $msg) {
                if (isset($msg['role']) && isset($msg['content'])) {
                    $messages[] = [
                        'role' => $msg['role'],
                        'content' => $msg['content']
                    ];
                }
            }
            
            // Crear cliente OpenAI directamente
            $client = \OpenAI::factory()
                ->withApiKey($apiKey)
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 30]))
                ->make();
            
            // Llamada directa a la API con logging detallado
            Log::info('Sending direct request to OpenAI API', [
                'model' => $model,
                'message_count' => count($messages),
                'api_key_length' => strlen($apiKey)
            ]);
            
            $apiResponse = $client->chat()->create([
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 800,
            ]);
            
            // Extraer texto de respuesta con validación
            $response = isset($apiResponse->choices[0]->message->content) 
                ? $apiResponse->choices[0]->message->content 
                : 'No se pudo obtener respuesta de la API.';
            
            // 5. Process successful response
            
            // Añadir información de diagnóstico para la respuesta exitosa
            Log::info('Respuesta exitosa de OpenAI API', [
                'response_length' => strlen($response),
                'source' => 'direct_api_call',
                'timestamp' => now()->toDateTimeString()
            ]);
            
            // Add AI response to journey history
            $journeyData['messages'][] = [
                'role' => 'assistant',
                'content' => $response,
                'timestamp' => now()->toString(),
                'source' => 'openai_api', // Marca explícita de que viene de la API
            ];
            
            // Update journey progress
            $currentProgress = $journeyData['progress'] ?? 0;
            $journeyData['progress'] = min(95, $currentProgress + 10);
            $journeyData['current_stage'] = $journeyData['current_stage'] ?? 1;
            
            // 6. Save updated journey data
            session(['ai_journey' => $journeyData]);
            
            // Log fin de solicitud exitosa
            Log::info('========== FIN SOLICITUD DE CHAT AI (EXITOSA) ==========');
            
            // 7. Return success response with API source indicator
            return response()->json([
                'success' => true,
                'message' => $response,
                'progress' => $journeyData['progress'],
                'source' => 'openai_api', // Indicador para el frontend de que es una respuesta real de la API
                'timestamp' => now()->toDateTimeString()
            ]);
            
        } catch (\Exception $e) {
            // Log inicio del manejo de errores
            Log::error('========== ERROR EN SOLICITUD DE CHAT AI ==========');
            Log::error('AI Journey Error Detallado: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'api_key_length' => strlen(env('OPENAI_API_KEY', '')),
                'model' => env('OPENAI_MODEL', 'unknown'),
                'request_data' => [
                    'message_length' => strlen($request->input('message', '')),
                    'has_files' => $request->hasFile('files')
                ]
            ]);
            
            // Mensajes de error más descriptivos y en español/árabe para el usuario
            $errorType = 'api_error';
            $userMessage = 'نعتذر، حدث خطأ أثناء الاتصال بخدمة الذكاء الاصطناعي. يرجى المحاولة مرة أخرى.'; // Mensaje en árabe
            
            // Clasificar el tipo de error para mensajes específicos
            if (strpos($e->getMessage(), 'api key') !== false || strpos($e->getMessage(), 'authentication') !== false) {
                $errorType = 'auth_error';
                $userMessage = 'خطأ في المصادقة مع خدمة الذكاء الاصطناعي. يرجى التحقق من إعدادات API في لوحة الإدارة.';
            } elseif (strpos($e->getMessage(), 'exceeded') !== false || strpos($e->getMessage(), 'limit') !== false) {
                $errorType = 'limit_error';
                $userMessage = 'تم تجاوز حد الاستخدام لخدمة الذكاء الاصطناعي. يرجى المحاولة مرة أخرى لاحقاً.';
            } elseif (strpos($e->getMessage(), 'timeout') !== false) {
                $errorType = 'timeout_error';
                $userMessage = 'تستغرق خدمة الذكاء الاصطناعي وقتاً طويلاً للرد. يرجى المحاولة مرة أخرى.';
            }
            
            // Log fin de manejo de error
            Log::error('========== FIN DE ERROR EN SOLICITUD DE CHAT AI ==========');
            
            // Return more specific user-friendly error con más detalles de diagnóstico
            return response()->json([
                'success' => false,
                'message' => $userMessage,
                'error' => $errorType,
                'error_from_api' => true, // Indicador explícito de que el error viene de la API real
                'timestamp' => now()->toDateTimeString(),
                'debug_info' => config('app.debug') ? [
                    'error_message' => $e->getMessage(),
                    'error_type' => get_class($e),
                    'api_connected' => true
                ] : null
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

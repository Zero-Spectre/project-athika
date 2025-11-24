<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MistralAIController extends Controller
{
    /**
     * Ask Mistral AI a question based on a discussion topic
     */
    public function askQuestion(Request $request)
    {
        // Validate the request
        $request->validate([
            'question' => 'required|string|max:1000',
            'context' => 'nullable|string|max:5000'
        ]);

        // Get the API key from environment with a fallback method
        $apiKey = env('OPENROUTER_API_KEY');
        
        // Fallback method to manually parse .env file if env() doesn't work
        if (!$apiKey) {
            $apiKey = $this->getEnvVariable('OPENROUTER_API_KEY');
        }
        
        // Log detailed information about the API key
        Log::info('Checking OpenRouter API key', [
            'api_key_value' => $apiKey ? substr($apiKey, 0, 10) . '...' : 'NULL',
            'api_key_length' => $apiKey ? strlen($apiKey) : 0,
            'env_function_works' => function_exists('env')
        ]);
        
        if (!$apiKey) {
            Log::error('OpenRouter API key not configured');
            return response()->json(['error' => 'OpenRouter API key not configured'], 500);
        }

        // Get the AI model from environment with fallback
        $model = env('AI_MODEL', 'mistralai/mistral-7b-instruct:free');
        if ($model === 'mistralai/mistral-7b-instruct:free') {
            $model = env('AI_MODEL') ?: $this->getEnvVariable('AI_MODEL') ?: 'mistralai/mistral-7b-instruct:free';
        }

        try {
            // Prepare the prompt
            // $prompt = "You are an educational AI assistant helping students with their coursework. ";
            $prompt = "jawablah pertanyaan ini dengan singkat dan tepat, buat kamu adalag asisten pendidikan:\n";
            $prompt .= "" . $request->question . "\n\n";
            
            // if ($request->context) {
            //     $prompt .= "Context: " . $request->context . "\n\n";
            // }
            
            // $prompt .= "Please provide a clear, concise, and educational response.";

            // Log the request for debugging
            Log::info('Sending request to OpenRouter API', [
                'question' => $request->question,
                'context_length' => strlen($request->context ?? ''),
                'api_key_present' => !empty($apiKey),
                'model' => $model
            ]);

            // Use Mistral model through OpenRouter
            $url = "https://openrouter.ai/api/v1/chat/completions";
            
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => url('/'), // Optional, for dashboard reporting
                'X-Title' => config('app.name'), // Optional, for dashboard reporting
            ])->post($url, [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);
            
            // Log the response status
            Log::info('OpenRouter API response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'failed' => $response->failed(),
                'body_sample' => substr($response->body(), 0, 200) . '...'
            ]);
            
            // Check if the request was successful
            if ($response->failed()) {
                $errorMessage = 'Failed to get response from Mistral AI. ';
                $errorMessage .= 'Status: ' . $response->status() . '. ';
                
                // Try to get more specific error information
                $responseData = $response->json();
                if ($responseData && isset($responseData['error'])) {
                    $errorMessage .= 'API Error: ' . ($responseData['error']['message'] ?? 'Unknown API error');
                }
                
                Log::error('Mistral API request failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return response()->json(['error' => $errorMessage], 500);
            }

            $responseData = $response->json();
            
            // Log successful response for debugging
            Log::info('Successful response from OpenRouter API', [
                'model' => $model,
                'has_choices' => isset($responseData['choices']),
                'response_keys' => array_keys($responseData)
            ]);
            
            // Check if we have choices in the response
            if (!isset($responseData['choices']) || empty($responseData['choices'])) {
                Log::error('No choices in OpenRouter API response', [
                    'response' => $responseData
                ]);
                
                return response()->json(['error' => 'No response generated from AI. Please try again.'], 500);
            }
            
            // Extract the answer from the response
            $answer = $responseData['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';
            
            // Log the raw answer to check for HTML tags
            Log::info('AI Response Content', [
                'raw_answer' => $answer,
                'answer_length' => strlen($answer),
                'has_html_tags' => preg_match('/<[^>]*>/', $answer),
                'html_tags_found' => preg_match_all('/<([^>]+)>/', $answer, $matches) ? $matches[1] : []
            ]);
            
            // Process markdown syntax to HTML if needed
            $answer = $this->processMarkdown($answer);
            
            // Check if the response was blocked or had finish reason
            if (isset($responseData['choices'][0]['finish_reason']) && $responseData['choices'][0]['finish_reason'] !== 'stop') {
                Log::warning('Response had unusual finish reason', [
                    'finish_reason' => $responseData['choices'][0]['finish_reason'],
                    'response' => $responseData
                ]);
            }

            return response()->json([
                'success' => true,
                'answer' => $answer
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in Mistral API request', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred while processing your request: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Process markdown syntax to HTML
     */
    private function processMarkdown($text)
    {
        // Convert markdown strikethrough (~~text~~) to HTML (<del>text</del>)
        $text = preg_replace('/~~(.*?)~~/', '<del>$1</del>', $text);
        
        // Convert markdown bold (**text**) to HTML (<strong>text</strong>)
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        
        // Convert markdown italic (*text*) to HTML (<em>text</em>)
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        
        return $text;
    }
    
    /**
     * Manually parse .env file to get environment variable as fallback
     */
    private function getEnvVariable($key)
    {
        $envFile = base_path('.env');
        if (!file_exists($envFile)) {
            return null;
        }
        
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($envKey, $envValue) = explode('=', $line, 2);
                $envKey = trim($envKey);
                $envValue = trim($envValue);
                // Remove quotes if present
                $envValue = trim($envValue, '"\'');
                
                if ($envKey === $key) {
                    return $envValue;
                }
            }
        }
        
        return null;
    }
}
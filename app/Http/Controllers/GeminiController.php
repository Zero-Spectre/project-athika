<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    /**
     * Ask Gemini AI a question based on a discussion topic
     */
    public function askQuestion(Request $request)
    {
        // Validate the request
        $request->validate([
            'question' => 'required|string|max:1000',
            'context' => 'nullable|string|max:5000'
        ]);

        // Get the API key from environment
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            Log::error('Gemini API key not configured');
            return response()->json(['error' => 'Gemini API key not configured'], 500);
        }

        try {
            // Prepare the prompt
            $prompt = "You are an educational AI assistant helping students with their coursework. ";
            $prompt .= "Please answer the following question in a helpful and educational manner:\n\n";
            $prompt .= "Question: " . $request->question . "\n\n";
            
            if ($request->context) {
                $prompt .= "Context: " . $request->context . "\n\n";
            }
            
            $prompt .= "Please provide a clear, concise, and educational response.";

            // Log the request for debugging
            Log::info('Sending request to Gemini API', [
                'question' => $request->question,
                'context_length' => strlen($request->context ?? ''),
                'api_key_present' => !empty($apiKey)
            ]);

            // Use the correct model names based on what's available
            // Prioritize models that are working and less likely to hit rate limits
            $modelsToTry = [
                'gemini-2.5-flash-preview-05-20', // Newer faster model, less likely to hit rate limits
                'gemini-1.5-flash',               // Stable model
                'gemini-1.5-pro',                 // More capable stable model
                'gemini-2.5-pro-preview-03-25',   // More capable model, but more likely to hit rate limits
            ];
            
            $response = null;
            $usedModel = null;
            
            foreach ($modelsToTry as $model) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                Log::info("Trying model: {$model}");
                
                $response = Http::timeout(30)->post($url, [
                    'contents' => [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]);
                
                // Check if the request was successful
                if ($response->successful()) {
                    $usedModel = $model;
                    Log::info("Successfully connected with model: {$model}");
                    break;
                }
                
                // Handle specific error cases
                $statusCode = $response->status();
                Log::warning("Failed with model: {$model}", [
                    'status' => $statusCode,
                    'response' => $response->body()
                ]);
                
                // If we hit rate limits, skip to the next model
                if ($statusCode == 429) {
                    Log::warning("Rate limit hit with model: {$model}, trying next model");
                    continue;
                }
                
                // If the model is not found, skip to the next model
                if ($statusCode == 404) {
                    Log::warning("Model not found: {$model}, trying next model");
                    continue;
                }
                
                // For service unavailable errors, we might want to retry or try another model
                if ($statusCode == 503) {
                    Log::warning("Service unavailable for model: {$model}, trying next model");
                    continue;
                }
            }
            
            // If all models failed, return the last error
            if (!$response || $response->failed()) {
                $errorMessage = 'Failed to get response from Gemini AI. ';
                $errorMessage .= 'Status: ' . ($response ? $response->status() : 'No response') . '. ';
                
                // Try to get more specific error information
                if ($response) {
                    $responseData = $response->json();
                    if ($responseData && isset($responseData['error'])) {
                        $errorMessage .= 'API Error: ' . ($responseData['error']['message'] ?? 'Unknown API error');
                    }
                }
                
                Log::error('Gemini API request failed with all models', [
                    'last_response_status' => $response ? $response->status() : 'No response',
                    'last_response_body' => $response ? $response->body() : 'No response'
                ]);
                
                return response()->json(['error' => $errorMessage], 500);
            }

            $responseData = $response->json();
            
            // Log successful response for debugging
            Log::info('Successful response from Gemini API', [
                'model_used' => $usedModel,
                'has_candidates' => isset($responseData['candidates']),
                'response_keys' => array_keys($responseData)
            ]);
            
            // Check if we have candidates in the response
            if (!isset($responseData['candidates']) || empty($responseData['candidates'])) {
                Log::error('No candidates in Gemini API response', [
                    'response' => $responseData
                ]);
                
                // Check for safety ratings or blocked content
                if (isset($responseData['promptFeedback'])) {
                    Log::error('Prompt was blocked', [
                        'promptFeedback' => $responseData['promptFeedback']
                    ]);
                    return response()->json(['error' => 'Your request was blocked by safety filters. Please try rephrasing your question.'], 500);
                }
                
                return response()->json(['error' => 'No response generated from AI. Please try again.'], 500);
            }
            
            // Extract the answer from the response
            $answer = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not generate a response.';
            
            // Check if the response was blocked
            if (isset($responseData['candidates'][0]['finishReason']) && $responseData['candidates'][0]['finishReason'] === 'SAFETY') {
                Log::error('Response was blocked by safety filters', [
                    'response' => $responseData
                ]);
                return response()->json(['error' => 'The response was blocked by safety filters. Please try rephrasing your question.'], 500);
            }

            return response()->json([
                'success' => true,
                'answer' => $answer,
                'model' => $usedModel // Include which model was used for debugging
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in Gemini API request', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred while processing your request: ' . $e->getMessage()], 500);
        }
    }
}
<?php
// Simple test script to verify Gemini API key and connectivity
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

if (!$apiKey) {
    echo "❌ API Key not found in environment\n";
    exit(1);
}

echo "✅ API Key found: " . substr($apiKey, 0, 10) . "...\n";

// Test API connectivity
$testPrompt = "What is 2+2?";

echo "📡 Testing API connectivity...\n";

try {
    $response = file_get_contents(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}",
        false,
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode([
                    'contents' => [
                        'parts' => [
                            ['text' => $testPrompt]
                        ]
                    ]
                ])
            ]
        ])
    );
    
    $responseData = json_decode($response, true);
    
    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        echo "✅ API Connection successful!\n";
        echo "🤖 AI Response: " . $responseData['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "❌ API Response format unexpected:\n";
        print_r($responseData);
    }
} catch (Exception $e) {
    echo "❌ API Connection failed: " . $e->getMessage() . "\n";
}
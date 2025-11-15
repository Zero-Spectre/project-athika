<?php
// Test script to check which Gemini models are available and working
require_once 'vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__.'/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

if (!$apiKey) {
    echo "❌ API Key not found in environment\n";
    exit(1);
}

echo "✅ API Key found: " . (substr($apiKey, 0, 10) . "..." ?? 'Present') . "\n";

// Test different models
$modelsToTry = [
    'gemini-pro',
    'gemini-1.5-pro',
    'gemini-1.0-pro',
    'gemini-ultra'
];

$testPrompt = "What is 2+2?";

foreach ($modelsToTry as $model) {
    echo "\n📡 Testing model: {$model}\n";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    $data = [
        'contents' => [
            'parts' => [
                ['text' => $testPrompt]
            ]
        ]
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json'
            ],
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    
    try {
        $response = file_get_contents($url, false, $context);
        $http_response_header = $http_response_header ?? [];
        
        // Get status code
        $status = 500;
        if (isset($http_response_header[0])) {
            preg_match('/HTTP\/\d\.\d\s+(\d+)/', $http_response_header[0], $matches);
            $status = isset($matches[1]) ? (int)$matches[1] : 500;
        }
        
        if ($status >= 200 && $status < 300) {
            $responseData = json_decode($response, true);
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                echo "✅ SUCCESS! Model {$model} is working\n";
                echo "🤖 Response: " . trim($responseData['candidates'][0]['content']['parts'][0]['text']) . "\n";
                break;
            } else {
                echo "⚠️  Model {$model} responded but format unexpected\n";
                echo "Response: " . substr($response, 0, 200) . "...\n";
            }
        } else {
            echo "❌ Model {$model} failed with status {$status}\n";
            if ($response) {
                $errorData = json_decode($response, true);
                if ($errorData && isset($errorData['error']['message'])) {
                    echo "Error: " . $errorData['error']['message'] . "\n";
                } else {
                    echo "Response: " . substr($response, 0, 200) . "...\n";
                }
            }
        }
    } catch (Exception $e) {
        echo "❌ Model {$model} failed with exception: " . $e->getMessage() . "\n";
    }
}
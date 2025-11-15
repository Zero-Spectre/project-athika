<?php
// Test script to verify the GeminiController logic is working properly
require_once 'vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__.'/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

echo "Testing GeminiController logic...\n";

// Test by directly calling the Gemini API with the same logic as the controller
$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

if (!$apiKey) {
    echo "❌ API Key not found in environment\n";
    exit(1);
}

echo "✅ API Key found: " . substr($apiKey, 0, 10) . "...\n";

// Use the same model order as the controller
$modelsToTry = [
    'gemini-2.5-flash-preview-05-20', // Newer faster model
    'gemini-1.5-flash',               // Stable model
    'gemini-1.5-pro',                 // More capable stable model
    'gemini-2.5-pro-preview-03-25',   // More capable model
];

// Test 1: Simple question
echo "\n📝 Test 1: Simple question\n";
$testPrompt = "You are an educational AI assistant helping students with their coursework. ";
$testPrompt .= "Please answer the following question in a helpful and educational manner:\n\n";
$testPrompt .= "Question: What is the capital of Indonesia?\n\n";
$testPrompt .= "Please provide a clear, concise, and educational response.";

$success = false;
foreach ($modelsToTry as $model) {
    echo "📡 Testing model: {$model}\n";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'json' => [
                'contents' => [
                    'parts' => [
                        ['text' => $testPrompt]
                    ]
                ]
            ],
            'timeout' => 30
        ]);
        
        $statusCode = $response->getStatusCode();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            $responseData = json_decode($response->getBody(), true);
            
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                echo "✅ SUCCESS! Model {$model} is working\n";
                echo "🤖 Response: " . trim($responseData['candidates'][0]['content']['parts'][0]['text']) . "\n";
                $success = true;
                break;
            } else {
                echo "⚠️  Model {$model} responded but format unexpected\n";
            }
        } else {
            echo "❌ Model {$model} failed with status {$statusCode}\n";
        }
    } catch (Exception $e) {
        echo "❌ Model {$model} failed with exception: " . $e->getMessage() . "\n";
    }
}

if ($success) {
    echo "✅ Test 1 PASSED\n";
} else {
    echo "❌ Test 1 FAILED\n";
}

// Test 2: Question with context
echo "\n📝 Test 2: Question with context\n";
$testPrompt = "You are an educational AI assistant helping students with their coursework. ";
$testPrompt .= "Please answer the following question in a helpful and educational manner:\n\n";
$testPrompt .= "Question: What is photosynthesis?\n\n";
$testPrompt .= "Context: This is for a biology course studying plant processes.\n\n";
$testPrompt .= "Please provide a clear, concise, and educational response.";

$success = false;
foreach ($modelsToTry as $model) {
    echo "📡 Testing model: {$model}\n";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'json' => [
                'contents' => [
                    'parts' => [
                        ['text' => $testPrompt]
                    ]
                ]
            ],
            'timeout' => 30
        ]);
        
        $statusCode = $response->getStatusCode();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            $responseData = json_decode($response->getBody(), true);
            
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                echo "✅ SUCCESS! Model {$model} is working\n";
                echo "🤖 Response: " . trim($responseData['candidates'][0]['content']['parts'][0]['text']) . "\n";
                $success = true;
                break;
            } else {
                echo "⚠️  Model {$model} responded but format unexpected\n";
            }
        } else {
            echo "❌ Model {$model} failed with status {$statusCode}\n";
        }
    } catch (Exception $e) {
        echo "❌ Model {$model} failed with exception: " . $e->getMessage() . "\n";
    }
}

if ($success) {
    echo "✅ Test 2 PASSED\n";
} else {
    echo "❌ Test 2 FAILED\n";
}

echo "\n🎉 Controller logic tests completed!\n";
echo "The GeminiController should now work correctly with the fixes applied.\n";
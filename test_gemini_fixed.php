<?php
// Fixed test script to verify Gemini API key and connectivity with proper error handling
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

echo "✅ API Key found: " . substr($apiKey, 0, 10) . "...\n";

// Test API connectivity with the same approach as the controller
$testPrompt = "What is 2+2?";

echo "📡 Testing API connectivity...\n";

// Use the same model order as the controller
$modelsToTry = [
    'gemini-2.5-flash-preview-05-20', // Newer faster model
    'gemini-1.5-flash',               // Stable model
    'gemini-1.5-pro',                 // More capable stable model
    'gemini-2.5-pro-preview-03-25',   // More capable model
];

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
    
    // Use Guzzle HTTP client like the controller does
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'json' => $data,
            'timeout' => 30
        ]);
        
        $statusCode = $response->getStatusCode();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            $responseData = json_decode($response->getBody(), true);
            
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                echo "✅ SUCCESS! Model {$model} is working\n";
                echo "🤖 Response: " . trim($responseData['candidates'][0]['content']['parts'][0]['text']) . "\n";
                echo "📝 Model used: {$model}\n";
                break;
            } else {
                echo "⚠️  Model {$model} responded but format unexpected\n";
                echo "Response keys: " . implode(', ', array_keys($responseData)) . "\n";
            }
        } else {
            echo "❌ Model {$model} failed with status {$statusCode}\n";
            $responseBody = $response->getBody();
            $errorData = json_decode($responseBody, true);
            if ($errorData && isset($errorData['error'])) {
                echo "Error: " . $errorData['error']['message'] . "\n";
            } else {
                echo "Response: " . substr($responseBody, 0, 200) . "...\n";
            }
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo "❌ Model {$model} failed with exception: " . $e->getMessage() . "\n";
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            echo "Status code: {$statusCode}\n";
            
            if ($statusCode == 429) {
                echo "⚠️  Rate limit hit, trying next model\n";
                continue;
            } elseif ($statusCode == 404) {
                echo "⚠️  Model not found, trying next model\n";
                continue;
            } elseif ($statusCode == 503) {
                echo "⚠️  Service unavailable, trying next model\n";
                continue;
            }
        }
    } catch (Exception $e) {
        echo "❌ Model {$model} failed with exception: " . $e->getMessage() . "\n";
    }
}
<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Check if TEST_BEARER_TOKEN is set
if (!isset($_ENV['TEST_BEARER_TOKEN'])) {
    die("ERROR: TEST_BEARER_TOKEN not found in .env file\n");
}

$baseUrl = 'https://awardpointsto.ft1.us/api/';
$token = $_ENV['TEST_BEARER_TOKEN'];

$client = new Client([
    'base_uri' => $baseUrl,
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ],
    'http_errors' => false // Don't throw exceptions for error responses
]);

// Helper function to make requests and handle responses
function makeRequest($client, $method, $endpoint, $data = null) {
    // Remove leading slash since base_uri has trailing slash
    $endpoint = ltrim($endpoint, '/');
    echo "\nTesting $method $endpoint\n";
    try {
        $options = [];
        if ($data) {
            $options['json'] = $data;
        }
        
        $response = $client->request($method, $endpoint, $options);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            echo "✅ Success! Status: $statusCode\n";
            if (!empty($body)) {
                echo "Response: $body\n";
                return json_decode($body, true);
            }
            return null;
        } else {
            echo "❌ Error! Status: $statusCode\n";
            echo "Response: $body\n";
            return null;
        }
    } catch (GuzzleException $e) {
        echo "❌ Error! " . $e->getMessage() . "\n";
        return null;
    }
}

// Test Houseteams endpoints
echo "\n=== Testing Houseteams Endpoints ===\n";

// GET /houseteams
$houseteams = makeRequest($client, 'GET', 'houseteams');

// POST /houseteams
$newHouseteam = makeRequest($client, 'POST', 'houseteams', [
    'name' => 'Test Houseteam ' . time()
]);

if ($newHouseteam && isset($newHouseteam['id'])) {
    $houseteamId = $newHouseteam['id'];

    // GET /houseteams/{id}
    makeRequest($client, 'GET', "houseteams/$houseteamId");

    // PUT /houseteams/{id}
    makeRequest($client, 'PUT', "houseteams/$houseteamId", [
        'name' => 'Updated Houseteam ' . time()
    ]);

    // GET /houseteams/{id}/houseteam-members
    makeRequest($client, 'GET', "houseteams/$houseteamId/houseteam-members");
}

// Test Houseteam Members endpoints
echo "\n=== Testing Houseteam Members Endpoints ===\n";

// GET /houseteam-members
$members = makeRequest($client, 'GET', 'houseteam-members');

// POST /houseteam-members
$newMember = makeRequest($client, 'POST', 'houseteam-members', [
    'name' => 'Test Member ' . time()
]);

if ($newMember && isset($newMember['id'])) {
    $memberId = $newMember['id'];

    // GET /houseteam-members/{id}
    makeRequest($client, 'GET', "houseteam-members/$memberId");

    // PUT /houseteam-members/{id}
    makeRequest($client, 'PUT', "houseteam-members/$memberId", [
        'name' => 'Updated Member ' . time()
    ]);

    // GET /houseteam-members/{id}/houseteams
    makeRequest($client, 'GET', "houseteam-members/$memberId/houseteams");

    // Test Points endpoint
    if ($newHouseteam && isset($newHouseteam['id'])) {
        echo "\n=== Testing Points Endpoint ===\n";
        
        // POST /points
        makeRequest($client, 'POST', 'points', [
            'points' => 100,
            'reason' => 'Test points transaction',
            'houseteam_member_id' => $memberId,
            'houseteam_id' => $newHouseteam['id']
        ]);
    }

    // Clean up - Delete houseteam member
    makeRequest($client, 'DELETE', "houseteam-members/$memberId");
}

// Clean up - Delete houseteam if it was created
if ($newHouseteam && isset($newHouseteam['id'])) {
    makeRequest($client, 'DELETE', "houseteams/{$newHouseteam['id']}");
}

echo "\nAPI Testing Complete!\n";

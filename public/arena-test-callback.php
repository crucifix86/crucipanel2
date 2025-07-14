<?php
/**
 * Arena Top 100 Callback Test Endpoint
 * 
 * This simple PHP file logs all Arena callbacks to help debug connection issues.
 * It works independently of Laravel and the database.
 * 
 * Access this at: https://yourdomain.com/arena-test-callback.php
 */

// Create logs directory if it doesn't exist
$logDir = __DIR__ . '/../storage/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}

$logFile = $logDir . '/arena-test-callbacks.log';

// Get all request data
$timestamp = date('Y-m-d H:i:s');
$method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
$requestUri = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN';

// Get POST/GET data
$getData = $_GET;
$postData = $_POST;
$rawInput = file_get_contents('php://input');

// Build log entry
$logEntry = [
    'timestamp' => $timestamp,
    'method' => $method,
    'ip' => $ip,
    'user_agent' => $userAgent,
    'request_uri' => $requestUri,
    'get_data' => $getData,
    'post_data' => $postData,
    'raw_input' => $rawInput
];

// Write to log file
$logLine = json_encode($logEntry) . PHP_EOL;
file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

// Simulate Arena callback response
$response = 'OK';

// Check if this looks like a valid Arena callback
if (isset($_POST['voted']) && isset($_POST['userid']) && isset($_POST['logid'])) {
    $response = 'OK - Test endpoint received Arena callback';
    
    // Log success
    $successEntry = [
        'timestamp' => $timestamp,
        'type' => 'ARENA_CALLBACK_RECEIVED',
        'userid' => $_POST['userid'],
        'logid' => $_POST['logid'],
        'voted' => $_POST['voted'],
        'userip' => $_POST['userip'] ?? 'NOT_PROVIDED'
    ];
    
    $successLine = json_encode($successEntry) . PHP_EOL;
    file_put_contents($logFile, $successLine, FILE_APPEND | LOCK_EX);
}

// Output response
header('Content-Type: text/plain');
echo $response;

// Also output debug info if in test mode
if (isset($_GET['debug'])) {
    echo "\n\n=== DEBUG INFO ===\n";
    echo "Timestamp: $timestamp\n";
    echo "Method: $method\n";
    echo "IP: $ip\n";
    echo "GET Data: " . json_encode($getData) . "\n";
    echo "POST Data: " . json_encode($postData) . "\n";
    echo "Raw Input: $rawInput\n";
    echo "\nLog file: $logFile\n";
    echo "Log file exists: " . (file_exists($logFile) ? 'YES' : 'NO') . "\n";
}
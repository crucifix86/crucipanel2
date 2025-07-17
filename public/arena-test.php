<?php
// Simple Arena callback test logger
// This will log all incoming requests to a file without needing database

$logFile = __DIR__ . '/../storage/logs/arena-callbacks.log';

// Create log entry
$logEntry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'get_params' => $_GET,
    'post_params' => $_POST,
    'raw_body' => file_get_contents('php://input'),
    'headers' => getallheaders() ?: []
];

// Write to log file
$logLine = date('Y-m-d H:i:s') . ' - ' . json_encode($logEntry) . PHP_EOL;
file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

// Return OK response
echo "OK - Request logged";
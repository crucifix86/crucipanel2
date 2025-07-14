<?php

require_once __DIR__ . '/vendor/autoload.php';

use hrace009\PerfectWorldAPI\API;

// Load Laravel's configuration
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $api = new API();
    
    echo "API Connection Status: " . ($api->online ? 'ONLINE' : 'OFFLINE') . "\n\n";
    
    // Test getRoleStatus method
    echo "Testing getRoleStatus method:\n";
    echo "================================\n";
    
    // Test with a known role ID (you'll need to replace this with an actual role ID)
    $testRoleId = 1024; // Example role ID
    
    echo "Attempting to get status for role ID: $testRoleId\n";
    
    try {
        $roleStatus = $api->getRoleStatus($testRoleId);
        echo "Role Status Response:\n";
        print_r($roleStatus);
        
        // Check if the response indicates the player is online
        // The status structure might contain online information
        if (isset($roleStatus['worldtag']) && $roleStatus['worldtag'] > 0) {
            echo "\nRole appears to be ONLINE (worldtag: " . $roleStatus['worldtag'] . ")\n";
        } else {
            echo "\nRole appears to be OFFLINE\n";
        }
    } catch (Exception $e) {
        echo "Error getting role status: " . $e->getMessage() . "\n";
    }
    
    echo "\n\nChecking protocol structure:\n";
    echo "================================\n";
    
    // Check what protocol codes are available
    if (isset($api->data['code'])) {
        echo "Available protocol codes:\n";
        foreach ($api->data['code'] as $name => $code) {
            echo "  $name => $code\n";
        }
    }
    
    // Check if there's a specific online check protocol
    echo "\n\nLooking for online-specific protocols:\n";
    foreach ($api->data['code'] as $name => $code) {
        if (stripos($name, 'online') !== false || stripos($name, 'status') !== false) {
            echo "  Found: $name => $code\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
<?php

// Diagnose welcome message issues
// Usage: php artisan tinker < artisan-commands/diagnose-welcome-message.php

use App\Models\WelcomeMessageSetting;
use App\Models\Message;
use App\Models\User;

echo "=== WELCOME MESSAGE DIAGNOSTICS ===\n\n";

// Check settings
$settings = WelcomeMessageSetting::first();
if ($settings) {
    echo "Settings found in database:\n";
    echo "ID: " . $settings->id . "\n";
    echo "Enabled (raw value): " . var_export($settings->enabled, true) . "\n";
    echo "Enabled (type): " . gettype($settings->enabled) . "\n";
    echo "Enabled (== true): " . ($settings->enabled == true ? 'true' : 'false') . "\n";
    echo "Enabled (=== true): " . ($settings->enabled === true ? 'true' : 'false') . "\n";
    echo "Enabled (== 1): " . ($settings->enabled == 1 ? 'true' : 'false') . "\n";
    echo "Enabled (=== 1): " . ($settings->enabled === 1 ? 'true' : 'false') . "\n";
    echo "\n";
    
    // Show all settings
    echo "All settings:\n";
    foreach ($settings->toArray() as $key => $value) {
        if ($key === 'message') {
            echo "  $key: " . substr($value, 0, 50) . "...\n";
        } else {
            echo "  $key: " . var_export($value, true) . "\n";
        }
    }
} else {
    echo "No settings found in database!\n";
}

echo "\n";

// Check if there are any welcome messages
$welcomeMessageCount = Message::where('is_welcome_message', true)->count();
echo "Total welcome messages in database: $welcomeMessageCount\n";

// Check latest users
$latestUsers = User::orderBy('ID', 'desc')->limit(3)->get(['ID', 'name', 'email', 'created_at']);
echo "\nLatest 3 users:\n";
foreach ($latestUsers as $user) {
    echo "  ID: {$user->ID}, Name: {$user->name}, Created: {$user->created_at}\n";
    $hasWelcomeMsg = Message::where('recipient_id', $user->ID)->where('is_welcome_message', true)->exists();
    echo "  Has welcome message: " . ($hasWelcomeMsg ? 'Yes' : 'No') . "\n\n";
}

// Check if admin user exists
$adminExists = User::where('ID', 1024)->exists();
echo "Admin user (ID 1024) exists: " . ($adminExists ? 'Yes' : 'No') . "\n";
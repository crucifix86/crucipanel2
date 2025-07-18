<?php

// Check welcome message status
// Usage: php artisan tinker < artisan-commands/check-welcome-message.php

use App\Models\WelcomeMessageSetting;

$settings = WelcomeMessageSetting::first();

if (!$settings) {
    echo "❌ No welcome message settings found in database.\n";
    echo "Visit /admin/welcome-message to initialize settings.\n";
} else {
    echo "Welcome Message Settings:\n";
    echo "========================\n";
    echo "Enabled: " . ($settings->enabled ? "✅ Yes" : "❌ No") . "\n";
    echo "Subject: " . $settings->subject . "\n";
    echo "Message: " . substr($settings->message, 0, 50) . "...\n";
    echo "Reward Enabled: " . ($settings->reward_enabled ? "✅ Yes" : "❌ No") . "\n";
    echo "Reward Type: " . $settings->reward_type . "\n";
    echo "Reward Amount: " . $settings->reward_amount . "\n";
    
    if (!$settings->enabled) {
        echo "\n⚠️  Welcome messages are currently DISABLED.\n";
        echo "To enable, visit /admin/welcome-message and check the 'Enable welcome message' checkbox.\n";
    }
}
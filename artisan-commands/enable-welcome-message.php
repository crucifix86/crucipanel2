<?php

// Manually enable welcome messages
// Usage: php artisan tinker < artisan-commands/enable-welcome-message.php

use App\Models\WelcomeMessageSetting;

$settings = WelcomeMessageSetting::first();

if (!$settings) {
    echo "Creating welcome message settings...\n";
    $settings = WelcomeMessageSetting::create([
        'enabled' => 1,  // Using 1 instead of true to ensure it's saved correctly
        'subject' => 'Welcome to ' . config('app.name', 'our server'),
        'message' => "Welcome to our server!\n\nWe're excited to have you join our community. This message contains a special reward for new players.\n\nTo claim your reward, simply read this message. The reward will be automatically added to your account.\n\nIf you have any questions, feel free to reach out to our support team.\n\nEnjoy your adventure!",
        'reward_enabled' => 1,
        'reward_type' => 'virtual',
        'reward_amount' => 1000,
    ]);
    echo "Settings created and enabled!\n";
} else {
    echo "Updating existing settings...\n";
    $settings->enabled = 1;  // Force it to 1
    $settings->save();
    echo "Settings updated - enabled is now: " . var_export($settings->enabled, true) . "\n";
}

// Verify
$settings->refresh();
echo "\nVerification:\n";
echo "Enabled (raw): " . var_export($settings->enabled, true) . "\n";
echo "Enabled (getRawOriginal): " . var_export($settings->getRawOriginal('enabled'), true) . "\n";
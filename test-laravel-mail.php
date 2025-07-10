<?php

// Laravel mail test script
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

echo "Testing Laravel Mail Configuration...\n\n";

// Show current mail configuration
echo "Current Mail Configuration:\n";
echo "- Default Mailer: " . config('mail.default') . "\n";
echo "- From Address: " . config('mail.from.address') . "\n";
echo "- From Name: " . config('mail.from.name') . "\n\n";

// Get mailer config
$mailerConfig = config('mail.mailers.' . config('mail.default'));
echo "Mailer Settings:\n";
foreach ($mailerConfig as $key => $value) {
    if ($key !== 'password') {
        echo "- $key: " . ($value ?? 'null') . "\n";
    }
}

echo "\nAttempting to send test email...\n";

$testEmail = "your-email@example.com"; // CHANGE THIS to your test email

try {
    Mail::raw('This is a test email from Laravel using the configured mail driver.', function ($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('Laravel Mail Test - CruciPanel2');
    });
    
    echo "✓ Email sent successfully!\n";
    echo "Check your inbox and spam folder.\n";
} catch (\Exception $e) {
    echo "✗ Failed to send email!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "Full error:\n" . $e->getTraceAsString() . "\n";
    
    // Log the error
    Log::error('Mail test failed', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

// Check mail logs
echo "\nCheck Laravel logs at: storage/logs/laravel.log\n";
<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Current Mail Configuration Debug\n";
echo "================================\n\n";

// Check environment
echo "Environment Variables:\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION') . "\n\n";

// Check config
echo "Config Values:\n";
echo "mail.default: " . config('mail.default') . "\n";
echo "mail.from.address: " . config('mail.from.address') . "\n";
echo "mail.from.name: " . config('mail.from.name') . "\n\n";

// Check mailer config
$mailer = config('mail.default');
$mailerConfig = config("mail.mailers.$mailer");
echo "Active Mailer ($mailer) Config:\n";
print_r($mailerConfig);
echo "\n";

// Check if PhpMailTransport is registered
echo "Checking if mail transport is registered...\n";
$transportManager = app('mail.manager')->getSymfonyTransport();
echo "Transport class: " . get_class($transportManager) . "\n\n";

// Try to send a test email
$testEmail = readline("Enter email address for test (or press Enter to skip): ");

if ($testEmail) {
    echo "\nAttempting to send test email...\n";
    
    try {
        Mail::raw('This is a test email from Laravel mail configuration test.', function ($message) use ($testEmail) {
            $message->to($testEmail)
                    ->subject('Test Email - ' . date('Y-m-d H:i:s'));
        });
        
        echo "✓ Mail::send() completed without throwing exception\n";
        echo "Check your email and also check /var/log/mail.log on the server\n";
        
    } catch (\Exception $e) {
        echo "✗ Error sending email:\n";
        echo $e->getMessage() . "\n";
        echo "\nFull trace:\n";
        echo $e->getTraceAsString() . "\n";
    }
}

echo "\nDone.\n";
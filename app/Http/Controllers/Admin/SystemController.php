<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class SystemController extends Controller
{
    /**
     * Show apps page
     *
     * @return Application|Factory|View
     */
    public function getApps()
    {
        $apps = config('pw-config.system.apps');
        return view('admin.system.applications', [
            'apps' => $apps,
        ]);
    }

    /**
     * Show settings page
     *
     * @return Application|Factory|View
     */
    public function getSettings()
    {
        return view('admin.system.settings');
    }

    /**
     * Show email configuration page
     *
     * @return Application|Factory|View
     */
    public function getEmailSettings()
    {
        $mailConfig = [
            'driver' => config('mail.default', 'smtp'),
            'host' => config('mail.mailers.smtp.host', ''),
            'port' => config('mail.mailers.smtp.port', 587),
            'username' => config('mail.mailers.smtp.username', ''),
            'encryption' => config('mail.mailers.smtp.encryption', 'tls'),
            'from_address' => config('mail.from.address', ''),
            'from_name' => config('mail.from.name', config('pw-config.server_name')),
        ];

        return view('admin.system.email', compact('mailConfig'));
    }

    /**
     * Save email configuration
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveEmailSettings(Request $request)
    {
        $request->validate([
            'mail_driver' => ['required', Rule::in(['smtp', 'mail', 'sendmail', 'mailgun', 'ses', 'log', 'array'])],
            'mail_host' => 'required_if:mail_driver,smtp',
            'mail_port' => 'required_if:mail_driver,smtp|numeric',
            'mail_username' => 'nullable',
            'mail_password' => 'nullable',
            'mail_encryption' => ['nullable', Rule::in(['tls', 'ssl', ''])],
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
        ]);

        // Update .env file
        $envData = [
            'MAIL_MAILER' => $request->mail_driver,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => $request->mail_from_name,
        ];
        
        // Only include SMTP settings if not using 'mail' or 'sendmail' driver
        if (!in_array($request->mail_driver, ['mail', 'sendmail', 'log'])) {
            $envData['MAIL_HOST'] = $request->mail_host ?: '';
            $envData['MAIL_PORT'] = $request->mail_port ?: '587';
            $envData['MAIL_USERNAME'] = $request->mail_username ?: '';
            $envData['MAIL_PASSWORD'] = $request->mail_password ?: '';
            $envData['MAIL_ENCRYPTION'] = $request->mail_encryption ?: 'null';
        } else {
            // For non-SMTP drivers, keep default values to avoid config issues
            // These values are ignored by mail/sendmail drivers anyway
            $envData['MAIL_HOST'] = 'localhost';
            $envData['MAIL_PORT'] = '25';
            $envData['MAIL_USERNAME'] = '';
            $envData['MAIL_PASSWORD'] = '';
            $envData['MAIL_ENCRYPTION'] = 'null';
        }
        
        $this->updateEnvironmentFile($envData);

        // Clear config cache and re-cache with new values
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');

        return redirect()->back()->with('success', __('Email configuration updated successfully'));
    }

    /**
     * Update .env file
     *
     * @param array $data
     */
    protected function updateEnvironmentFile(array $data)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            // Handle special cases
            if ($key === 'MAIL_ENCRYPTION' && empty($value)) {
                $value = 'null';
            }

            // Escape special characters
            if (strpos($value, ' ') !== false || strpos($value, '#') !== false) {
                $value = '"' . $value . '"';
            }

            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Test email configuration
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testEmailSettings(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            \Mail::raw('This is a test email from ' . config('pw-config.server_name') . ' to verify your email configuration is working correctly.', function($message) use ($request) {
                $message->to($request->test_email)
                        ->subject('Test Email - ' . config('pw-config.server_name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully! Check your inbox.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save configuration
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveApps(Request $request): RedirectResponse
    {
        $apps = config('pw-config.system.apps');
        foreach (array_keys($apps) as $app) {
            if ($request->has($app) === true) {
                Config::write('pw-config.system.apps.' . $app, true);
            } else {
                Config::write('pw-config.system.apps.' . $app, false);
            }
        }
        
        // Clear and re-cache config to apply changes
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        
        return redirect()->back()->with('success', __('admin.configSaved'));
    }

    /**
     * Save settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveSettings(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'server_name' => 'required|string',
            'discord' => 'required|string',
            'currency_name' => 'required|string',
            'server_ip' => 'required|ipv4',
            'server_version' => 'required|string',
            'encryption_type' => 'required|string',
            'gmwa' => 'required|numeric',
            'fakeonline' => 'required|numeric',
        ]);

        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => [
                    'image',
                    'mimes:png',
                    Rule::dimensions()->ratio(1 / 1 )->width(128)->height(128)
                ]
            ]);
            $logo = $request->file('logo')->getClientOriginalName();
            Config::write('pw-config.logo', $logo);
            $request->file('logo')->storeAs('logo', $logo, config('filesystems.default'));
        }

        foreach ($validate as $settings => $value) {
            Config::write('pw-config.' . $settings, $value);
        }
        Config::write('app.name', $request->get('server_name'));
        Config::write('app.timezone', $request->get('datetimezone'));
        
        // Clear and re-cache config to apply changes
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        
        // Use query parameter instead of session flash
        return redirect()->route('admin.settings', ['saved' => 1]);
    }
}

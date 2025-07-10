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
            'driver' => env('MAIL_MAILER', 'smtp'),
            'host' => env('MAIL_HOST', ''),
            'port' => env('MAIL_PORT', 587),
            'username' => env('MAIL_USERNAME', ''),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'from_address' => env('MAIL_FROM_ADDRESS', ''),
            'from_name' => env('MAIL_FROM_NAME', config('pw-config.server_name')),
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
            'mail_driver' => ['required', Rule::in(['smtp', 'sendmail', 'mailgun', 'ses', 'log', 'array'])],
            'mail_host' => 'required_if:mail_driver,smtp',
            'mail_port' => 'required_if:mail_driver,smtp|numeric',
            'mail_username' => 'nullable',
            'mail_password' => 'nullable',
            'mail_encryption' => ['nullable', Rule::in(['tls', 'ssl', ''])],
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
        ]);

        // Update .env file
        $this->updateEnvironmentFile([
            'MAIL_MAILER' => $request->mail_driver,
            'MAIL_HOST' => $request->mail_host ?: '',
            'MAIL_PORT' => $request->mail_port ?: '587',
            'MAIL_USERNAME' => $request->mail_username ?: '',
            'MAIL_PASSWORD' => $request->mail_password ?: '',
            'MAIL_ENCRYPTION' => $request->mail_encryption ?: 'null',
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => $request->mail_from_name,
        ]);

        // Clear config cache
        \Artisan::call('config:clear');

        flash()->success(__('Email configuration updated successfully'));
        return redirect()->back();
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
        Config::set('app.timezone', $request->get('datetimezone'));
        Config::set('app.name', $request->get('server_name'));
        return redirect()->back()->with('success', __('admin.configSaved'));
    }
}

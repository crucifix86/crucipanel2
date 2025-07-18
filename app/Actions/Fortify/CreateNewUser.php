<?php






/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Message;
use App\Models\WelcomeMessageSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     */
    public function create(array $input)
    {
        if (Features::enabled(Features::twoFactorAuthentication())) {
            if (config('pw-config.system.apps.captcha')) {
                Validator::make($input, [
                    'name' => $this->RegisterPageUserNameRules(),
                    'email' => $this->RegisterPageEmailRules(),
                    'password' => $this->RegisterPagePasswordRules(),
                    'captcha' => $this->captchaRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
                ])->validate();
            } else {
                Validator::make($input, [
                    'name' => $this->RegisterPageUserNameRules(),
                    'email' => $this->RegisterPageEmailRules(),
                    'password' => $this->RegisterPagePasswordRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
                ])->validate();
            }


            $userId = (User::all()->count() > 0) ? User::orderBy('ID', 'desc')->first()->ID + 16 : 1024;
            
            $user = User::create([
                'ID' => $userId,
                'name' => $input['name'],
                'email' => $input['email'],
                'phonenumber' => null,
                'passwd' => Hash::make($input['name'] . $input['password']),
                'passwd2' => Hash::make($input['name'] . $input['password']),
                'answer' => config('app.debug') ? $input['password'] : '',
                'truename' => null,
                'creatime' => Carbon::now(),
            ]);
            
            // Send welcome message after user creation
            if ($user) {
                // Find the user by email to ensure we have the correct ID
                $createdUser = User::where('email', $input['email'])->first();
                if ($createdUser) {
                    \Log::info('User created with ID: ' . $createdUser->ID . ', sending welcome message');
                    $this->sendWelcomeMessage($createdUser);
                }
            }
            
            return $user;
        } else {
            if (config('pw-config.system.apps.captcha')) {
                Validator::make($input, [
                    'name' => $this->RegisterPageUserNameRules(),
                    'email' => $this->RegisterPageEmailRules(),
                    'password' => $this->RegisterPagePasswordRules(),
                    'pin' => $this->RegisterPagePinRules(),
                    'captcha' => $this->captchaRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
                ])->validate();
            } else {
                Validator::make($input, [
                    'name' => $this->RegisterPageUserNameRules(),
                    'email' => $this->RegisterPageEmailRules(),
                    'password' => $this->RegisterPagePasswordRules(),
                    'pin' => $this->RegisterPagePinRules(),
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
                ])->validate();
            }
            $userId = (User::all()->count() > 0) ? User::orderBy('ID', 'desc')->first()->ID + 16 : 1024;
            
            $user = User::create([
                'ID' => $userId,
                'name' => $input['name'],
                'email' => $input['email'],
                'phonenumber' => null,
                'passwd' => Hash::make($input['name'] . $input['password']),
                'passwd2' => Hash::make($input['name'] . $input['password']),
                'answer' => config('app.debug') ? $input['password'] : '',
                'qq' => $input['pin'],
                'truename' => null,
                'creatime' => Carbon::now(),
            ]);
            
            // Send welcome message after user creation
            if ($user) {
                // Find the user by email to ensure we have the correct ID
                $createdUser = User::where('email', $input['email'])->first();
                if ($createdUser) {
                    \Log::info('User created with ID: ' . $createdUser->ID . ', sending welcome message');
                    $this->sendWelcomeMessage($createdUser);
                }
            }
            
            return $user;
        }
    }
    
    /**
     * Send welcome message to newly registered user
     */
    private function sendWelcomeMessage(User $user)
    {
        \Log::info('Attempting to send welcome message to user ID: ' . $user->ID);
        
        $settings = WelcomeMessageSetting::first();
        
        if (!$settings) {
            \Log::info('No welcome message settings found');
            return;
        }
        
        if (!$settings->enabled) {
            \Log::info('Welcome messages are disabled');
            return;
        }
        
        // Ensure we have a valid user ID
        if (!$user->ID) {
            \Log::error('User ID is null or empty');
            return;
        }
        
        // Get system user ID (admin)
        $systemUserId = 1024; // Default admin ID
        
        try {
            $message = Message::create([
                'sender_id' => $systemUserId,
                'recipient_id' => $user->ID,
                'subject' => $settings->subject,
                'message' => $settings->message,
                'is_read' => false,
                'is_welcome_message' => true,
            ]);
            \Log::info('Welcome message created successfully with ID: ' . $message->id);
        } catch (\Exception $e) {
            // Log the error but don't fail user registration
            \Log::error('Failed to send welcome message: ' . $e->getMessage());
            \Log::error('Exception trace: ' . $e->getTraceAsString());
        }
    }
}

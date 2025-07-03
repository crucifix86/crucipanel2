<?php






/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Actions\Fortify;

use App\Models\User;
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


            return User::create([
                'ID' => (User::all()->count() > 0) ? User::orderBy('ID', 'desc')->first()->ID + 16 : 1024,
                'name' => $input['name'],
                'email' => $input['email'],
                'phonenumber' => null,
                'passwd' => Hash::make($input['name'] . $input['password']),
                'passwd2' => Hash::make($input['name'] . $input['password']),
                'answer' => config('app.debug') ? $input['password'] : '',
                'truename' => null,
                'creatime' => Carbon::now(),
            ]);
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
            return User::create([
                'ID' => (User::all()->count() > 0) ? User::orderBy('ID', 'desc')->first()->ID + 16 : 1024,
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
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'css_content',
        'js_content',
        'layout_content',
        'is_active',
        'is_visible',
        'is_default',
        'is_auth_theme',
        'is_mobile_theme',
        'is_editable'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
        'is_default' => 'boolean',
        'is_auth_theme' => 'boolean',
        'is_mobile_theme' => 'boolean',
        'is_editable' => 'boolean'
    ];

    public static function getActive()
    {
        // Check if this is a mobile device
        $isMobile = self::isMobileDevice();
        
        // Check if we're on an auth page
        // Since EnsurePreLogin returns view directly, we need to check referrer too
        $referrer = request()->headers->get('referer', '');
        $isAuthPage = request()->routeIs('login', 'register', 'password.*', 'pre-login') ||
                      request()->is('login', 'register', 'password/*', 'forgot-password', 'reset-password/*') ||
                      str_contains($referrer, '/login') ||
                      str_contains($referrer, '/register') ||
                      str_contains($referrer, '/password') ||
                      (!auth()->check() && request()->path() === 'theme/css'); // Theme CSS loading from auth page
        
        // If on auth page, return the auth theme
        if ($isAuthPage) {
            $authTheme = self::where('is_auth_theme', true)->first();
            if ($authTheme) {
                return $authTheme;
            }
        }
        
        // If mobile device, try to get mobile theme
        if ($isMobile) {
            // Check if user has a mobile theme preference
            if (auth()->check() && auth()->user()->mobile_theme_id) {
                $userMobileTheme = self::find(auth()->user()->mobile_theme_id);
                if ($userMobileTheme && $userMobileTheme->is_visible) {
                    session(['active_theme_id' => $userMobileTheme->id]);
                    return $userMobileTheme;
                }
            }
            
            // Otherwise get the default mobile theme
            $defaultMobileTheme = self::where('is_mobile_theme', true)
                                    ->where('is_active', true)
                                    ->first();
            if ($defaultMobileTheme) {
                session(['active_theme_id' => $defaultMobileTheme->id]);
                return $defaultMobileTheme;
            }
        }
        
        // Get user's selected theme if logged in
        if (auth()->check() && auth()->user()->theme_id) {
            $userTheme = self::find(auth()->user()->theme_id);
            if ($userTheme && $userTheme->is_visible) {
                // Store in session for consistency across pages
                session(['active_theme_id' => $userTheme->id]);
                return $userTheme;
            }
        }
        
        // Check session for theme (for consistency when not logged in on some pages)
        if (session()->has('active_theme_id')) {
            $sessionTheme = self::find(session('active_theme_id'));
            if ($sessionTheme && $sessionTheme->is_visible) {
                return $sessionTheme;
            }
        }
        
        // Otherwise return the active theme (site default)
        return self::where('is_active', true)->first() ?: self::where('is_default', true)->first();
    }
    
    public static function getVisibleThemes()
    {
        return self::where('is_visible', true)->get();
    }
    
    /**
     * Detect if the current request is from a mobile device
     */
    public static function isMobileDevice()
    {
        $userAgent = request()->header('User-Agent', '');
        
        // Mobile detection regex pattern
        $mobilePattern = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i';
        
        // Additional pattern for tablets
        $tabletPattern = '/android|webos|ipad|playbook|silk/i';
        
        // Check if it's a mobile device (phone or tablet)
        return preg_match($mobilePattern, $userAgent) || preg_match($tabletPattern, $userAgent);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clone($newName, $newDisplayName)
    {
        $clone = $this->replicate();
        $clone->name = $newName;
        $clone->display_name = $newDisplayName;
        $clone->is_active = false;
        $clone->is_default = false;
        $clone->is_editable = true;
        $clone->is_visible = true; // Make sure new themes are visible!
        $clone->save();
        
        return $clone;
    }
}

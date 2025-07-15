<?php






/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('language')) {
            $language = $request->get('language');
            
            // Validate language is supported
            if (in_array($language, ['en', 'id'])) {
                // Store in session for all users
                session(['locale' => $language]);
                
                // If authenticated, save to database
                if (Auth::user()) {
                    Auth::user()->language = $language;
                    Auth::user()->save();
                }
                
                App::setLocale($language);
            }
        } elseif (Auth::user() && Auth::user()->language) {
            App::setLocale(Auth::user()->language);
        } elseif (session()->has('locale')) {
            App::setLocale(session('locale'));
        } else {
            App::setLocale(config('app.locale', 'en'));
        }
        
        return $next($request);
    }
}

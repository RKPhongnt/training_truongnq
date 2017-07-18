<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class RedirectIfAuthenticated
{
 
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //if user logined return to admin or user dashboard
        
        if (Auth::check()) {
            $user = Auth::user();
            
           if ($user->is_admin == 1) {
               return redirect('admin');
           }
           return redirect('user');
        }
        return $next($request);
    }
}

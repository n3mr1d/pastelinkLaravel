<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * Only allow access if the user is authenticated and is_admin is true.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        if ($role === 'admin' && !$user->is_admin) {
            return redirect('/dashboard')->with([
                'error' => 'Unauthorized access for onlyadmin'
            ]);     
           }
        
        if ($role === 'user' && $user->is_admin) {
            return redirect('/admin')->with([
                'error' => 'Unauthorized for users only'
            ]);
        }
        

        return $next($request);
    }
}

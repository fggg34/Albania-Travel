<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComingSoon
{
    /**
     * Handle an incoming request.
     * Show coming soon page unless COMING_SOON is false, or user is admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only active when COMING_SOON is enabled
        if (! config('app.coming_soon', false)) {
            return $next($request);
        }

        // Allow admin panel
        $adminPath = config('app.filament_admin_path', 'backend');
        if (str_starts_with($request->path(), $adminPath)) {
            return $next($request);
        }

        // Allow auth routes (login, register, password reset, etc.)
        $authPaths = [
            'login',
            'register',
            'forgot-password',
            'reset-password',
            'verify-email',
            'email/verification-notification',
            'confirm-password',
        ];
        foreach ($authPaths as $path) {
            if ($request->is($path) || $request->is($path . '/*')) {
                return $next($request);
            }
        }

        // Allow health check
        if ($request->is('up')) {
            return $next($request);
        }

        // Allow POST to auth (login form, etc.)
        if ($request->isMethod('post') && in_array($request->path(), ['login', 'register', 'forgot-password', 'logout'])) {
            return $next($request);
        }
        if ($request->isMethod('post') && str_starts_with($request->path(), 'reset-password')) {
            return $next($request);
        }
        if ($request->isMethod('post') && $request->path() === 'email/verification-notification') {
            return $next($request);
        }
        if ($request->isMethod('post') && $request->path() === 'confirm-password') {
            return $next($request);
        }

        // Admin user sees full site
        if ($request->user()?->role === 'admin') {
            return $next($request);
        }

        return response()->view('coming-soon');
    }
}

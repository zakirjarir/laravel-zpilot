<?php

namespace ZakirJarir\LaravelInstaller\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next)
    {
        if (!file_exists(storage_path('installed')) && !$request->is('install') && !$request->is('install/*')) {
            config(['session.driver' => 'file']);
            return redirect()->route('installer.welcome');
        }

        return $next($request);
    }
}

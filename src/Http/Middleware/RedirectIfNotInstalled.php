<?php

namespace ZakirJarir\LaravelZPilot\Http\Middleware;

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
            return redirect()->route('zpilot.welcome');
        }

        return $next($request);
    }
}

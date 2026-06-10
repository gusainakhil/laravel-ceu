<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureUtmParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasAny(['utm_source', 'utm_medium', 'utm_campaign'])) {
            $utmData = [
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'captured_at' => now()->toDateTimeString(),
            ];

            session(['utm_data' => $utmData]);
        }

        return $next($request);
    }
}

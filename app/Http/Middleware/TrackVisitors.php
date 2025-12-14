<?php

namespace App\Http\Middleware;

use App\Models\Analytics\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for specific routes/paths
        $excludedPaths = [
            'api/*',
            'admin/visitors*', // Don't track the visitors page itself
            'build/*',
            'storage/*',
            'img/*',
        ];

        foreach ($excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // Skip tracking for non-GET requests or AJAX calls if desired
        // if (!$request->isMethod('GET')) {
        //     return $next($request);
        // }

        try {
            $userAgent = $request->userAgent() ?? '';
            
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'url' => $request->fullUrl(),
                'referer' => $request->header('referer'),
                'method' => $request->method(),
                'device_type' => Visitor::detectDevice($userAgent),
                'browser' => Visitor::detectBrowser($userAgent),
                'platform' => Visitor::detectPlatform($userAgent),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break the request
            // Log::error('Visitor tracking failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}

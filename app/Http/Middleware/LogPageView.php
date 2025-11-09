<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        PageView::firstOrCreate(
            [
                'session_id' => $request->session()->getId(),
                'path' => $request->path(),
            ],
            [
                'user_id' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        return $next($request);
    }
}

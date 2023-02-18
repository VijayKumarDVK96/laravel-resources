<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if($request->ip() == '127.0.0.1') { // Ignores for localhost, only for live
            return $next($request);
        } else {

            if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
                $response = [
                    'success' => false,
                    'message' => 'All requests should be passed in HTTPS only',
                ];

                return response()->json($response, 400);
                die;
            }

            return $next($request);
        }
    }
}

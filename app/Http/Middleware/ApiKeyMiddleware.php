<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Extract the API key from the Authorization header
        $authorization = $request->header('Authorization'); 

        // Check if the Authorization header is present and starts with "Bearer "
        if ($authorization && strpos($authorization, 'Bearer ') === 0) {
            $apiKey = substr($authorization, 7); // Extract API key (everything after "Bearer ")

            // Debugging: Check if we have the correct API key
            // dd($apiKey, "Extracted API Key");

            // Validate the API Key
            if ($apiKey !== config('services.khalti.public_key')) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

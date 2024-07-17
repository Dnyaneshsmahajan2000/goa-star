<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVchTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
      
        if (in_array($request->vch_type, ['sale', 'purchase','sale_return','purchase_return','order'])) {
            // Proceed with the request
            return $next($request);
        }

        // If vch_type is missing or has an invalid value, return an error response
       // return response()->json(['error' => 'Invalid vch_type'], 400);
       throw new \InvalidArgumentException('Invalid vch_type');


        
    }
}

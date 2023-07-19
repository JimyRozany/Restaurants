<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApprovedByAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$verified = Auth::guard('restaurant-guard')->user()->verified){
            return response()->json([
                'status' => 'error',
                'message'=> 'unauthorized , your account in not verified',
            ] ,401);
        }
        return $next($request);
    }
}

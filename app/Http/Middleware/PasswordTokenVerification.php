<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordTokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('UpdatePassToken');
        $result = JWTToken::VerifyToken($token);

        if ($result === 'Unauthorized') {
            header('location: /loginRegister');
            return response()->json([
                'status' => 'failed',
                'message' => 'ulauthorized'
            ]);
        }else{
            $request->headers->set('email', $result->userEmail);
            return $next($request);
        }

    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Log;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\NotAuthorisedException; //401
use App\Exceptions\NoPermissionException; //403

class ManageToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next, $allowedGuards, $role)
    {
        $submittedGuard = $allowedGuards;
        $guards = explode('|', $allowedGuards);
        //  dd($submittedGuard);
        foreach($guards as $guard) {
            if($guard === $submittedGuard) {
                auth()->shouldUse($guard);
            }
        }
        try {
            if(auth()->authenticate()) {
                 if($this->hasPermission($role, auth()->user())) {
                    return $next($request);
                 }else{
                 return response()->json([
                'errors' => [
                    'message' => 'You do not have permission to view this page.',
                    'status_code' => 401
                 ]
            ]);
            }
        }
        } catch (AuthenticationException $e) {
            try {
                $this->checkForToken($request);
                $this->auth->parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                try {
                    $newtoken = $this->auth->parseToken()->refresh();
                    $response = $next($request);

                    if($this->hasPermission($role, auth()->user())) {
                        $response->header('Authorization', 'Bearer ' . $newtoken);
                        return $response;
                    }else{
                 return response()->json([
                'errors' => [
                   'message' => 'You do not have permission to view this page.',
                    'status_code' => 401]
            ])->header('Authorization', 'Bearer ' . $newtoken);
            }
                } catch (TokenExpiredException $e) {
                    //refresh token expired
                    return response()->json([
                                'errors' => [
                                    'message' => 'You do not have permission to view this page.',
                                    'status_code' => 401
                                ]
                            ]);
                }
            }
        }       
            return response()->json([
                                'errors' => [
                                    'message' => 'You do not have permission to view this page.',
                                    'status_code' => 401
                                ]
                            ]);
    } 

/**
     * check user has permission to access
     *
     */
    private function hasPermission(string $allowedRoles, $user)//: bool
    {
        // dd($allowedRoles);
        $roles = explode('|', $allowedRoles);

        foreach($roles as $role) {
            if($role == $user->role) {
                return true;
            }
        }         
         return response()->json([
                                'errors' => [
                                    'message' => 'You do not have permission to view this page.',
                                    'status_code' => 401
                                ]
                            ]);
    }
}
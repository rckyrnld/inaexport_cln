<?php

namespace App\Http\Middleware;


use Closure;
use App\User;
use Auth;

class DocAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $res = User::where('id',Auth::user()->id)->first();

        if($res->id_role != 1){
           return redirect('/home');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\ItdpCompanyUser;
use Closure;
use Auth;
use Cache;
use Carbon\Carbon;

class LastUserActivityEksmp
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('eksmp')->check()) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-is-eksmp-' . Auth::guard('eksmp')->user()->id, true, $expiresAt);

            /* user last seen */
            ItdpCompanyUser::where('id', Auth::guard('eksmp')->user()->id)->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Carbon;
use App\Models\User\UserIp;

class CheckIp
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
        if(!$request->user()) {
            if(UserIp::where('ip', $request->ip())->exists()) {
                $ips = UserIp::where('ip', $request->ip())->get();
                foreach($ips as $ip) {
                    if($ip->user->is_banned) return redirect('/ip-block');
                }
            }
        }
        else {
            if($request->user()->is_banned) {
                return redirect('/banned');
            }
        }
    
        return $next($request);
    }
}

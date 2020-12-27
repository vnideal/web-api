<?php

namespace App\Http\Middleware;

use App\Biz\UserBiz;
use Closure;
use Illuminate\Http\Request;

class VerifyActiveUser
{
    /**
     * Handle an active user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user->status != UserBiz::STATUS_VERIFIED) {
            abort(403, "User's email address is unverified");
        }

        return $next($request);
    }
}

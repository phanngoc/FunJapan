<?php

namespace App\Http\Middleware;

use App\Events\ActivityLogEvent;
use Closure;

class ActivityLogMiddleware
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
        if (!$request->cookie('session_id')) {
            $sessionId = uniqid(rand(), false);

            event(new ActivityLogEvent($request, auth()->user(), $sessionId));

            return $next($request)->cookie('session_id', $sessionId, config('user.session_user_life_time'));
        } else {
            event(new ActivityLogEvent($request, auth()->user()));

            return $next($request);
        }
    }
}

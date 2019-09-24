<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class canModerator
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
        $user = User::find($request->userId);

        if($user->role->name == 'admin')
        {
            return response()->json('Forbidden', 403);
        }

        return $next($request);
    }
}

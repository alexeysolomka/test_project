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
        
        // if founded user is admin and current user not admin then forbidden
        if($user->role->name == 'admin' && !auth()->user()->checkRole('admin'))
        {
            return response()->json('Forbidden', 403);
        }

        return $next($request);
    }
}

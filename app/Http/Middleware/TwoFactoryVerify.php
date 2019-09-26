<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;

class TwoFactoryVerify
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
        $user = Auth::user();

        if($user->token_2fa_expiry > Carbon::now())
        {
            return $next($request);
        }

        $twilio = new TwilioService();

        $user->token_2fa = mt_rand(10000, 99999);
        $user->save();

        $twilio->createMessage($user->phone_number, $user->token_2fa);

        return redirect('/2fa');
    }
}

<?php

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        $user = User::where('email', $event->credentials['email'])->first();
        if(!empty($user))
        {
            if(!$user->is_active)
            {
                Auth::logout();
                return back()->with('error', 'User is inactive.');
            }
            return;
        }

        return back()->with('error', 'User is not found.');
    }
}

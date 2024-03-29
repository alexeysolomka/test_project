<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    public function verifyTwoFactor(Request $request)
    {
        $verifyAccountRule = User::$twoFactorVerifyRule;
        $request->validate($verifyAccountRule);

        if($request->input('2fa') == Auth::user()->token_2fa){
            $user = Auth::user();
            $user->token_2fa = null;
            $user->token_2fa_expiry = Carbon::now()->addMinutes(config('session.lifetime'));
            $user->save();

            return redirect('/home');
        } else {
            return redirect('/2fa')->with('error', 'Incorrect code.');
        }
    }

    public function showForm()
    {
        return view('auth.two_factor');
    }
}

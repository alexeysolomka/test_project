<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json(['errors' => $errors]);
        }
        $credentials = request(['email', 'password']);
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            $succeess['token'] = $user->createToken('RestToken')->accessToken;
            return response()
                ->json(['success' => $succeess], 200);
        }
        else
        {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}

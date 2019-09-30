<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public static $createRules = [
        'name' => 'required|min:3|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'is_active' => 'required|boolean',
        'avatar' => 'mimes:jpeg,jpg,png,gif',
        'phone_number' => 'required|unique:users',
        'role_id' => 'required|exists:roles,id',
        'password' => 'min:8|confirmed|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])\w{8,}$/',
    ];
    public static $updateRules = [
        'name' => 'required|min:3|string|max:255',
        'role_id' => 'sometimes|integer|exists:roles,id',
        'avatar' => 'mimes:jpeg,jpg,png,gif',
        'phone_number' => 'required|unique:users,id,',
        'email' => 'required|string|email|max:255|unique:users,id,',
    ];
    public static $twoFactorVerifyRule = [
        '2fa' => 'required'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number', 'password', 'is_active', 'role_id', 'avatar',
        'token_2fa', 'token_2fa_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function checkRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!empty($roleName)) {
            return auth()->user()->role_id == $role->id;
        }

        return false;
    }
}

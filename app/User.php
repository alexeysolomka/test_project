<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'role_id', 'avatar'
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

    public function createUserRules()
    {
        return [
            'name' => 'required|min:3|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'avatar' => 'mimes:jpeg,jpg,png,gif',
            'role_id' => 'required|exists:roles,id',
            'password' => 'min:8|confirmed|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])\w{8,}$/',
        ];
    }

    public function updateUserRules()
    {
        return [
            'name' => 'required|min:3|string|max:255',
            'role_id' => 'sometimes|integer|exists:roles,id',
            'avatar' => 'mimes:jpeg,jpg,png,gif',
            'email' => 'required|string|email|max:255|unique:users,id' . $this->id,
        ];
    }
}

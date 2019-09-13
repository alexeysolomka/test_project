<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'key', 'controller', 'method'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, PermissionRole::class, 'role_id', 'id', 'id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

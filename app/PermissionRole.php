<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    protected $fillable = ['permission_id', 'role_id'];
    public $timestamps = false;
}

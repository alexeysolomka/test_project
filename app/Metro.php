<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metro extends Model
{
    public static $createRules = [];
    public static $updateRules = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location'];

    public function stations()
    {
        return $this->hasMany(Branch::class);
    }
}

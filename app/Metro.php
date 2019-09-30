<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metro extends Model
{
    public static $createRules = ['location' => 'required|string|unique:metros'];
    public static $updateRules = ['location' => 'required|string|unique:metros,location,'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metro extends Model
{
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

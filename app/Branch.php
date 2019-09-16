<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}

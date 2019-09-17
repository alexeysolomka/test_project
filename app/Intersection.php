<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intersection extends Model
{
    protected $fillable = ['name'];

    public function stations()
    {
        return $this->hasMany(Station::class, 'intersection_to_stations');
    }
}

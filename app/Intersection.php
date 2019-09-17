<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intersection extends Model
{
    protected $fillable = ['name'];

    public function stations()
    {
        return $this->hasManyThrough(Station::class, IntersectionToStation::class,
            'intersection_id',
            'id',
            'id',
            'station_id'
            );
    }
}

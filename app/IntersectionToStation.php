<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


class IntersectionToStation extends Pivot
{
    protected $fillable = ['intersection_id', 'station_id'];
    protected $table = 'intersection_to_stations';
    public $timestamps = false;
}

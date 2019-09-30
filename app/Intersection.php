<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Intersection extends Model
{
    public static $createRules = [
        'name' => 'required|unique:intersections'
    ];
    public static $updateRules = [
        'name' => 'required|unique:intersections,name,'
    ];

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

    public function availableStations()
    {
        $ids = DB::table('intersection_to_stations')->where('intersection_id', $this->id)->pluck('station_id');
    
        return Station::whereNotIn('id', $ids)->get();
    }
}

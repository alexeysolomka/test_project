<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function availableStations()
    {
        $ids = DB::table('intersection_to_stations')->where('intersection_id', $this->id)->pluck('station_id');
    
        return Station::whereNotIn('id', $ids)->get();
    }

    public static function createValidationRules()
    {
        return [
            'name' => 'required|unique:intersections'
        ];
    }

    public static function updateValidationRules($id)
    {
        return [
            'name' => 'required|unique:intersections,id,' . $id
        ];
    }
}

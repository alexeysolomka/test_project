<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['branch_id', 'name', 'next'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function next()
    {
        return $this->hasOne(Station::class);
    }

    public function intersections()
    {
        return $this->hasManyThrough(Intersection::class, IntersectionToStation::class,
            'station_id',
            'id',
            'id',
            'intersection_id'
            );
    }

    public static function createValidationRules()
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|unique:stations'
        ];
    }

    public static function updateValidationRules($station_id)
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|unique:stations,id,' . $station_id
        ];
    }
}

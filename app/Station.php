<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public static $createRules = [
        'branch_id' => 'required|exists:branches,id',
        'name' => 'required|unique:stations'
    ];
    public static $updateRules = [
        'branch_id' => 'required|exists:branches,id',
        'name' => 'required|unique:stations,name,'
    ];
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
}

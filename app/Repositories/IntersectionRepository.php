<?php

namespace App\Repositories;

use App\Interfaces\ICoreRepository;
use App\Intersection;
use App\IntersectionToStation;

class IntersectionRepository implements ICoreRepository
{
    public function getAll()
    {
        $intersections = Intersection::select('id', 'name')
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $intersections;
    }

    public function create($data)
    {
        $intersection = Intersection::create([
            'name' => $data['name']
        ]);

        return $intersection;
    }

    public function update($id, $data)
    {
        $intersection = Intersection::find($id);
        $intersection->update($data);

        return $intersection;
    }

    public function addStationToIntersection($intersection_id, $station_id)
    {
        $intersectionStation = IntersectionToStation::create([
            'intersection_id' => $intersection_id,
            'station_id' => $station_id
        ]);

        return $intersectionStation;
    }
}

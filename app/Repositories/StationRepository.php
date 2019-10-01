<?php

namespace App\Repositories;

use App\Interfaces\ICoreRepository;
use App\Station;

class StationRepository implements ICoreRepository
{
    public function getAll()
    {
        $stations = Station::with('branch', 'intersections')
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $stations;
    }

    public function getStationsForSelect()
    {
        $columns = ['id', 'name'];
        $stations = Station::select($columns)
        ->get();

        return $stations;
    }

    public function create($data)
    {
        $station = Station::create([
            'branch_id' => $data['branch_id'],
            'name' => $data['name'],
            'next' => $data['next']
        ]);

        return $station;
    }

    public function update($id, $data)
    {
        $station = Station::find($id);
        $station->update($data);

        return $station;
    }
}

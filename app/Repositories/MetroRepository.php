<?php

namespace App\Repositories;

use App\Metro;
use App\Interfaces\ICoreRepository;

class MetroRepository implements ICoreRepository
{
    public function getAll()
    {
        $columns = ['id', 'location'];
        $metros = Metro::select($columns)
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $metros;
    }

    public function create($data)
    {
        $metro = Metro::create([
            'location' => $data['location'],
        ]);

        return $metro;
    }

    public function update($id, $data)
    {
        $metro = Metro::find($id);
        $metro->update($data);

        return $metro;
    }
}

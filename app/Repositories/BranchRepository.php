<?php

namespace App\Repositories;

use App\Branch;
use App\Interfaces\ICoreRepository;

class BranchRepository implements ICoreRepository
{
    public function getAll()
    {
        $columns = ['id', 'metro_id', 'name'];
        $branches = Branch::with('metro')
            ->select($columns)
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $branches;
    }

    public function create($data)
    {
        $branch = Branch::create([
            'name' => $data['name'],
            'metro_id' => $data['metro_id']
        ]);

        return $branch;
    }

    public function update($id, $data)
    {
        $branch = Branch::find($id);
        $branch->update($data);

        return $branch;
    }
}

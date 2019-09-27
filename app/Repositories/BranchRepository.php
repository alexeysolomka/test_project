<?php

namespace App\Repositories;

use App\Branch;
use App\Interfaces\ICoreRepository;

class BranchRepository implements ICoreRepository
{
    public function getAll()
    {
        $columns = ['id', 'name'];
        $branches = Branch::select($columns)
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $branches;
    }

    public function create($data)
    {
        $branch = Branch::create([
            'name' => $data['name'],
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

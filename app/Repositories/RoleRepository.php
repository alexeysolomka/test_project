<?php


namespace App\Repositories;


use App\Interfaces\ICoreRepository;
use App\Role;

class RoleRepository implements ICoreRepository
{
    public function getAll()
    {
        $roles = Role::select('id', 'name')
            ->get();

        return $roles;
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }
}

<?php


namespace App\Repositories;


use App\Interfaces\ICoreRepository;
use App\User;

class UserRepository implements ICoreRepository
{
    public function getAll()
    {
        $columns = ['id', 'name', 'email'];
        $users = User::select($columns)
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $users;
    }

    public function create($data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'is_active' => $data->is_active,
            'password' => bcrypt($data->password)
        ]);

        return $user;
    }

    public function update($id, $data)
    {
        $userData = $data->all();
        $user = User::find($id);
        $user->update($userData);

        return $user;
    }
}

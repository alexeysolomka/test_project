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

    public function getById($id)
    {
        $columns = ['id', 'name', 'email', 'created_at', 'updated_at'];
        $user = User::where('id', $id)->first();

        return $user;
    }

    public function create($data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password)
        ]);

        return $user;
    }

    public function update($id, $data)
    {
        $user = $this->getById($id);
        $user->name = $data->name;
        $user->email = $data->email;
        $user->touch();

        return $user;
    }

    public function delete($id)
    {
        $user = $this->getById($id);

        return $user->delete();
    }
}

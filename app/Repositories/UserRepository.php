<?php


namespace App\Repositories;


use App\Interfaces\ICoreRepository;
use App\User;

class UserRepository implements ICoreRepository
{
    public function getAll()
    {
        $columns = ['id', 'name', 'email', 'role_id'];
        $users = User::select($columns)
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $users;
    }

    public function create($data)
    {
        $avatar = null;
        if(array_key_exists('avatar', $data))
        {
            $avatar = $data['avatar'];
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'is_active' => $data['is_active'],
            'role_id' => $data['role_id'],
            'avatar' => $avatar,
            'password' => bcrypt($data['password'])
        ]);

        return $user;
    }

    public function update($id, $data)
    {
        $user = User::find($id);
        $user->update($data);

        return $user;
    }
}

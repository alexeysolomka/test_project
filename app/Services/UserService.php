<?php


namespace App\Services;


use App\Repositories\RoleRepository;
use App\User;

class UserService
{
    private $roleRepository;

    public function __construct()
    {
        $this->roleRepository = app(RoleRepository::class);
    }

    public function getUserRoles()
    {
        $roles = [];
        if(auth()->user()->role_id == 1)
        {
            $roles = $this->roleRepository->getAll();
        }

        return $roles;
    }

    public function getUserForEdit($userId)
    {
        switch (auth()->user()->role_id)
        {
            case 1: {
                $user = User::find($userId);
                break;
            }
            case 2: {
                $user = User::find($userId);
                if($user->role_id != 1) break;
            }
            default: {
                $user = auth()->user();
            }
        }

        return $user;
    }
}

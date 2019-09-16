<?php

use App\Permission;
use App\PermissionRole;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')
            ->insert([
                [
                    'controller' => 'App\Http\Controllers\HomeController',
                    'method' => 'index'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'create'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'store'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'edit'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'profile'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'update'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'destroy'
                ],
                [
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'removeAvatar'
                ],
            ]);

        $permissions = Permission::all();

        $roleAdmin = Role::where('name', 'admin')->first();
        $roleModerator = Role::where('name', 'moderator')->first();
        $roleUser = Role::where('name', 'user')->first();

        foreach($permissions as $permission)
        {
            PermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => $roleAdmin->id
            ]);
            PermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => $roleModerator->id
            ]);
        }
        $indexPagePermission = Permission::where('method', 'index')->first()->id;
        $editProfilePermission = Permission::where('method', 'profile')->first()->id;
        $updateProfilePermission = Permission::where('method', 'update')->first()->id;
        $removeAvatarPermission = Permission::where('method', 'removeAvatar')->first()->id;
        PermissionRole::create([
            'permission_id' => $indexPagePermission,
            'role_id' => $roleUser->id
        ]);
        PermissionRole::create([
            'permission_id' => $editProfilePermission,
            'role_id' => $roleUser->id
        ]);
        PermissionRole::create([
            'permission_id' => $updateProfilePermission,
            'role_id' => $roleUser->id
        ]);
        PermissionRole::create([
            'permission_id' => $removeAvatarPermission,
            'role_id' => $roleUser->id
        ]);
    }
}

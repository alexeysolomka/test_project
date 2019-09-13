<?php

use App\Permission;
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
            $roleAdmin->permissions()->attach($permission);
            $roleModerator->permissions()->attach($permission);
        }
        $indexPagePermission = Permission::where('method', 'index')->first()->id;
        $editProfilePermission = Permission::where('method', 'edit')->first()->id;
        $updateProfilePermission = Permission::where('method', 'update')->first()->id;
        $removeAvatarPermission = Permission::where('method', 'removeAvatar')->first()->id;
        $roleUser->permissions()->attach([$indexPagePermission, $editProfilePermission, $updateProfilePermission, $removeAvatarPermission]);
    }
}

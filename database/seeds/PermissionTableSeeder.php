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
                    'key' => 'user',
                    'controller' => 'App\Http\Controllers\HomeController',
                    'method' => 'index'
                ],
                [
                    'key' => '',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'create'
                ],
                [
                    'key' => '',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'store'
                ],
                [
                    'key' => 'user',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'edit'
                ],
                [
                    'key' => 'user',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'update'
                ],
                [
                    'key' => '',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'destroy'
                ],
                [
                    'key' => 'user',
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

            if($permission->key == 'user')
            {
                $roleUser->permissions()->attach($permission);
            }
        }
    }
}

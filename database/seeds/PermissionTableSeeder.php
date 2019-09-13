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
                    'key' => 'user|admin|moderator',
                    'controller' => 'App\Http\Controllers\HomeController',
                    'method' => 'index'
                ],
                [
                    'key' => 'admin|moderator',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'create'
                ],
                [
                    'key' => 'admin|moderator',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'store'
                ],
                [
                    'key' => 'user|admin|moderator',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'edit'
                ],
                [
                    'key' => 'user|admin|moderator',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'update'
                ],
                [
                    'key' => 'admin|moderator',
                    'controller' => 'App\Http\Controllers\UserController',
                    'method' => 'destroy'
                ],
                [
                    'key' => 'user|admin|moderator',
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
            $keys = explode('|', $permission->key);

            for($i = 0; $i < sizeof($keys); $i++)
            {
                if($keys[$i] == 'admin') $roleAdmin->permissions()->attach($permission);
                if($keys[$i] == 'moderator') $roleModerator->permissions()->attach($permission);
                if($keys[$i] == 'user') $roleUser->permissions()->attach($permission);
            }
        }
    }
}

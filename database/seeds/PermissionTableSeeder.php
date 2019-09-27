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
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'index'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'store'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'show'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'profile'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'update'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'destroy'
                ],
                [
                    'controller' => 'App\Http\Controllers\Api\UserController',
                    'method' => 'updateProfile'
                ],
                // CRUD Stations
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'index'
                ],
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'create'
                ],
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'store'
                ],
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'edit'
                ],
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'update'
                ],
                [
                    'controller' => 'App\Http\Controllers\StationController',
                    'method' => 'delete'
                ],
                // CRUD Branches
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'index'
                ],
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'create'
                ],
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'store'
                ],
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'edit'
                ],
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'update'
                ],
                [
                    'controller' => 'App\Http\Controllers\BranchController',
                    'method' => 'delete'
                ],
                // Intersections
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'index',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'create',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'store',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'edit',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'update',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'delete',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'addStationToIntersection',
                ],
                [
                    'controller' => 'App\Http\Controllers\IntersectionController',
                    'method' => 'deleteStationFromIntersection',
                ],
            ]);

        $permissions = Permission::all();

        $roleAdmin = Role::where('name', 'admin')->first();
        $roleModerator = Role::where('name', 'moderator')->first();
        $roleUser = Role::where('name', 'user')->first();

        //admin permissions
        foreach($permissions as $permission)
        {
            PermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => $roleAdmin->id
            ]);    
        }

        //moderator permissions
        $permissions = Permission::where('controller', '!=', 'App\Http\Controllers\StationController')
        ->where('controller', '!=', 'App\Http\Controllers\BranchController')
        ->where('controller', '!=', 'App\Http\Controllers\IntersectionController')
        ->get();
        foreach($permissions as $permission)
        {
            PermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => $roleModerator->id
            ]);
        }
        //User permissions
        $indexPagePermission = Permission::where('controller', 'App\Http\Controllers\HomeController')
            ->where('method', 'index')->first()->id;
        $editProfilePermission = Permission::where('controller', 'App\Http\Controllers\UserController')
            ->where('method', 'profile')->first()->id;
        $updateProfilePermission = Permission::where('controller', 'App\Http\Controllers\UserController')
            ->where('method', 'update')->first()->id;
        $removeAvatarPermission = Permission::where('controller', 'App\Http\Controllers\UserController')
            ->where('method', 'removeAvatar')->first()->id;

        $apiIndexPagePermission = Permission::where('controller', 'App\Http\Controllers\Api\UserController')
            ->where('method', 'index')->first()->id;
        $apiEditProfilePermission = Permission::where('controller', 'App\Http\Controllers\Api\UserController')
            ->where('method', 'profile')->first()->id;
        $apiUpdateProfilePermission = Permission::where('controller', 'App\Http\Controllers\Api\UserController')
            ->where('method', 'updateProfile')->first()->id;

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
        // API
        PermissionRole::create([
            'permission_id' => $apiIndexPagePermission,
            'role_id' => $roleUser->id
        ]);
        PermissionRole::create([
            'permission_id' => $apiEditProfilePermission,
            'role_id' => $roleUser->id
        ]);
        PermissionRole::create([
            'permission_id' => $apiUpdateProfilePermission,
            'role_id' => $roleUser->id
        ]);
    }
}

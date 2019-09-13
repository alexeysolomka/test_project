<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids = [];

        foreach(Route::getRoutes()->getRoutes() as $key => $route)
        {
            $action = $route->getActionname();

            $_action = explode('@', $action);

            $controller = $_action[0];
            $method = end($_action);

            $permission_check = Permission::where(
                ['controller' => $controller, 'method' => $method]
            )->first();
            if(!$permission_check)
            {
                $permission = new Permission;
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->save();
                $permission_ids[] = $permission->id;
            }
            $admin_role = Role::where('name', 'admin')->first();
            $admin_role->permissions()->attach($permission_ids);
        }
    }
}

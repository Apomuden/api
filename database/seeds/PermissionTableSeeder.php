<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
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
        $permission_ids = []; // an empty array of stored permission IDs
        // iterate though all routes

        $routes=Route::getRoutes()->getRoutes();
        foreach ($routes as $key => $route)
        {
            // get route action
            $name=$route->getName();
            $action = $route->getActionname();// separating controller and method
            $_action = explode('@',$action);

            $controller = $_action[0];
            $method = end($_action);

            // check if this permission is already exists
            $permission_check = Permission::where(
                    ['controller'=>$controller,'method'=>$method]
                )->first();
            if(!$permission_check){
            $permission = new Permission;
            $permission->name=$name;
            $permission->controller = $controller;
            $permission->method = $method;
            $permission->save();
            // add stored permission id in array
            $permission_ids[] = $permission->id;
            }
        }// find admin role.
        $admin_role = Role::where('name','Admin')->first();// atache all permissions to admin role
        $admin_role->permissions()->attach($permission_ids);
    }
}

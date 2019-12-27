<?php

use App\Models\Component;
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

            // Check if Component Exist
            $_component=explode('\\',$controller);
            $component_name=str_replace('Controller','',end($_component));

            $component=Component::where(['name'=>$component_name])->first();

            if(!$component){
               $component=new Component;
               $component->name=$component_name;
               $component->save();
            }



              // check if this permission is already exists
              $permission = Permission::where(
                ['controller'=>$controller,'method'=>$method]
            )->first();

            if(!$permission){
                $permission = new Permission;
                $permission->name=$name;
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->component_id=$component->id;
                $permission->save();
                // add stored permission id in array
                $permission_ids[] = $permission->id;
            }
            else if(!$permission->component_id)
            {
                $permission->component_id=$component->id;
                $permission->save();
            }
        }// find admin role.
        $admin_role = Role::where('name','Admin')->first();// atache all permissions to admin role
        $admin_role->permissions()->attach($permission_ids);
        $admin_role->attachPermissionsToUsers();
    }
}

<?php

use App\Http\Helpers\Security;
use App\Models\Component;
use App\Models\ComponentModule;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // iterate though all routes
        DB::beginTransaction();
        $routes=Route::getRoutes()->getRoutes();
        foreach ($routes as $key => $route)
        {
            $action = $route->getAction();
            $name=$route->getName();
            $module=$action['module']??null;
            $component=$action['component']??null;
            //$parent_component=$action['parent_component']??null;

            if( is_null($module) || is_null($component))
                continue;

            $dbModules=Security::getModuleByTag($module)??null;
            $dbComponent=Security::getComponentByTag($component)??null;
            if(is_array($dbModules))
            {

               foreach($dbModules as $dbModule){
                 $componentModule=ComponentModule::where('component_id',$dbComponent->id)
                        ->where('module_id',$dbModule->id)->first();

                 //If Exists
                 if($componentModule)
                   continue;

                ComponentModule::create([
                     'component_id'=>$dbComponent->id,
                     'module_id'=>$dbModule->id,
                 ]);


               }
            }
            else if($dbModules)
            {
                $componentModule=ComponentModule::where('component_id',$dbComponent->id)
                        ->where('module_id',$dbModules->id)->first();

                //If Exists
                if($componentModule)
                        continue;


                 ComponentModule::create([
                            'component_id'=>$dbComponent->id,
                            'module_id'=>$dbModules->id,
                ]);

            }
        }

        //Syn Admin Role
        $adminRole=Role::where('name', 'Dev')->first();
        if(!$adminRole)
         $adminRole=Role::create(['name' => 'Dev']);


        //Sync Role to components
        $synPayload = [];
        $components=ComponentModule::all();
         foreach($components as $component){
            $synPayload[] = [
                'id' => $component->component_id,//This is the component
                'all' => true
            ];
         }
        $adminRole->syncComponents($synPayload);
        DB::commit();
    }
}

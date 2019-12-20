<?php

use App\Http\Resources\PermissionCollection;
use App\Models\Component;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=Permission::orderBy('name')->get();
       foreach($permissions as $permission){
        $_controller=explode('\\',$permission->controller);
        $module_name=ucwords($_controller[count($_controller)-2]);
        if($module_name=='Auth') $module_name='Authentication';
           $module=Module::where(['name'=>$module_name])->first();

           if(!$module){
               $module=new Module;
               $module->name=$module_name;
               $module->save();
           }
       }

       $permissions=Permission::all();
       //$components=[];
       foreach($permissions as $permission){
        $_controller=explode('\\',$permission->controller);
        $module_name=ucwords($_controller[count($_controller)-2]);

        if($module_name=='Auth') $module_name='Authentication';

        $module=Module::where('name',$module_name)->first();
           if($module && $module->name==$module_name){
               if(!$module->components()->find($permission->component_id))
               $module->components()->attach([$permission->component_id]);

           }
       }
    }
}

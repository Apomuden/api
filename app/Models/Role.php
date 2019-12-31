<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class Role extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function modules()
    {
       //$this->join('mo')
    }

    public function getPermissionsPaginatedAttribute()
    {
      return $this->permissions()->active()->sortBy('name')->paginate(10);
    }

    public function attachPermissionsToUsers($permissions=null){
        $users=$this->users;
        foreach($users as $user){
            try{
                $user->permissions()->attach($permissions??$this->permissions);
            }
            catch(Exception $e){
                continue;
            }
        }
    }

    public function detachPermissionsFromUsers($permissions=null){
        $users=$this->users;
        foreach($users as $user){
            try{
                $user->permissions()->detach($permissions??$this->permissions);
            }
            catch(Exception $e){
                continue;
            }
        }
    }

    public function attachPermissions($permissions){
        try{
            $this->permissions()->attach($permissions);
            $this->attachPermissionsToUsers($permissions);
        }
        catch(Exception $e){ }
    }
    public function detachPermissions($permissions,$cascade=false){
        try{
            $this->permissions()->detach($permissions);
            if($cascade)
            $this->detachPermissionsFromUsers($permissions);
        }
        catch(Exception $e){ }
    }
    public function attachModules($module_ids){
       $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids)->get();
       foreach($modules as $module){
          $components=$module->components;
          foreach($components as $component){
              try{
                $permissions=$component->permissions;
                $this->permissions()->attach($permissions);
                $this->attachPermissionsToUsers($permissions);
              }
              catch(Exception $e){
                continue;
              }

          }
       }
    }

    public function detachModules($module_ids,$cascade=false){
        $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids)->get();
        foreach($modules as $module){
           $components=$module->components;
           foreach($components as $component){
               try{
                    $permissions=$component->permissions;
                    $this->permissions()->detach($permissions);
                    if($cascade)
                    $this->detachPermissionsFromUsers($permissions);
               }
               catch(Exception $e){
                    continue;
               }

           }
        }
     }


     public function attachComponents($component_ids){
        $components=Component::with('permissions')->get();
           foreach($components as $component){
               try{
                 $permissions=$component->permissions;
                 $this->permissions()->attach($permissions);
                 $this->attachPermissionsToUsers($permissions);
               }
               catch(Exception $e){
                 continue;
               }
         }
     }

     public function detachComponents($component_ids,$cascade){
        $components=Component::with('permissions')->get();
           foreach($components as $component){
               try{
                 $permissions=$component->permissions;
                 $this->permissions()->detach($permissions);

                 if($cascade)
                 $this->detachPermissionsFromUsers($permissions);
               }
               catch(Exception $e){
                 continue;
               }
         }
     }
}

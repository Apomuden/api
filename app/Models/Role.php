<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Role extends Model
{
    use ActiveTrait;
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
      return $this->permissions()->active()->orderBy('name')->paginate(10);
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

    public function detachPermissionsToUsers($permissions=null){
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

    public function attachModules($module_ids){
       $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids)->get();
       foreach($modules as $module){
          $components=$module->components;
          foreach($components as $component){
              $permissions=$component->permissions;
              $this->permissions()->attach($permissions);
              $this->attachPermissionsToUsers($permissions);
          }
       }
    }

    public function detachModules($module_ids,$revoke_all_users=false){
        $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids);
        foreach($modules as $module){
           $components=$module->components;
           foreach($components as $component){
               $permissions=$component->permissions;
               $this->permissions()->detach($permissions);
               if($revoke_all_users)
               $this->detachPermissionsToUsers($permissions);
           }
        }
     }
}

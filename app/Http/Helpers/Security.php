<?php

namespace App\Http\Helpers;

use App\Models\Component;
use App\Models\ComponentRole;
use App\Models\Module;
use App\Repositories\RepositoryEloquent;
use App\Models\ComponentUser;
use App\Models\ServiceRule;
use Illuminate\Support\Facades\Hash;

class Security
{
    static function confirmPassword($plain_password, $hash_password, $id)
    {
        return Hash::check(trim($plain_password) . trim($id), trim($hash_password));
    }

    static function getNewPasswordHash($plain_password, $id)
    {
        return Hash::make(trim($plain_password) . trim($id));
    }

    static function getModuleByTag($tag)
    {
        $repository = new RepositoryEloquent(new Module());
        $modules = [];
        if (is_array($tag)) {
            foreach ($tag as $tg) {
                $modules[] = $repository->getModel()->where('tag', $tg)->first(['name','id','tag']) ?? null;
            }
            return $modules;
        } else {
            return $repository->getModel()->where('tag', $tag)->first(['name','id','tag']) ?? null;
        }
    }

    static function getComponentByTag($tag)
    {
        $repository = new RepositoryEloquent(new Component());
        return $repository->getModel()->where('tag', $tag)->first(['name','id','tag']) ?? null;
    }

    static function getRolePermissions($role_id, $component_id)
    {
        return ComponentRole::where('role_id', $role_id)
                        ->where('component_id', $component_id)
                        ->select(['all','add','view','edit','update','delete','print'])
                        ->first();
    }
    static function getUserPermissions($user_id, $component_id)
    {
        return ComponentUser::where('user_id', $user_id)
            ->where('component_id', $component_id)
            ->select(['all','add', 'view', 'edit', 'update', 'delete', 'print'])
            ->first();
    }

    static function getServiceRule(string $rule,$patient_status=null){
       $rule=ServiceRule::whereName($rule);

       if($patient_status)
       $rule=$rule->findby(['patient_status'=>'='.$patient_status]);

       return $rule->first();
    }
    static function getServiceRules(array $rules, $patient_status = null){
       $rules=ServiceRule::whereIn('name',$rules);

        if ($patient_status)
        $rules = $rules->findby(['patient_status' => '=' . $patient_status]);

        return $rules->get();
    }
}

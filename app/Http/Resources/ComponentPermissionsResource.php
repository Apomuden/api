<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use App\Http\Helpers\Security;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ComponentPermissionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id)){
            $role_id=request()->route('role')??null;
            $user_id= request()->route('profile')??(request()->route('user')??null);


            $data= [
                'id'=>$this->id,
                'name'=>$this->name,
                'tag'=>$this->tag??null,
                'status'=>$this->status,

            ];

            if($role_id)
            $permissions = Security::getRolePermissions($role_id,$this->id);
            elseif($user_id)
            $permissions = Security::getUserPermissions($user_id, $this->id);


            $data=array_merge($data,
                [  'permissions'=>((isset($permissions) && $permissions)? [
                        'all' => (bool) $permissions->all,
                        'add' => (bool) $permissions->add,
                        'view' => (bool) $permissions->view,
                        'update' => (bool) $permissions->update,
                        'delete' => (bool) $permissions->delete,
                        'print' => (bool) $permissions->print
                ]:null)

                ]);

            $data=array_merge($data,[
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ]);

            return $data;
        }
        else
           return NULL;
    }
}

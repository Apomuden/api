<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use App\Models\Component;
use App\Models\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class ModulePermissionsResource extends JsonResource
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
            //$components=($this->components && count($this->components))?ComponentPermissionsResource::collection($this->components):[];
            $components=[];
            $parents=[];

            if($this->tag!='sys-mgt'){
                $components = $this->components()->where('tag', 'not like', 'setup.%')->orderBy('name')->get();
                $components=($components && count($components))?ComponentPermissionsResource::collection($components):[];
            }

            else{
                //Get setup parent module tags
                $components = $this->components()->where('tag', 'like', 'setup.%')->orderBy('name')->get();
                foreach($components as $component){
                      if(!$component->parent_tag)
                         continue;

                       //$parentModule=Module::where('tag', $component->parent_tag)->first();

                      $parents[$component->parent_tag][]=new ComponentPermissionsResource($component);
                }

                //formatting display
                $components=[];
                foreach($parents as $key=>$value){
                    $parentModule = Module::where('tag',$key)->first();


                    $components[]= [
                        'id'=>$parentModule->id,
                        'name' => $parentModule->name,
                        'status' => $parentModule->status,
                        'components'=> $parents[$key],
                        'created_at' => DateHelper::toDisplayDateTime($parentModule->created_at),
                        'updated_at' => DateHelper::toDisplayDateTime($parentModule->updated_at)
                    ];
                }
            }




            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'status'=>$this->status,
                ($this->tag != 'sys-mgt'?'components':'submodules')=>$components,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
           return NULL;
    }
}

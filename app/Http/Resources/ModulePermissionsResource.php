<?php

namespace App\Http\Resources;

use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\DateHelper;
use App\Http\Helpers\Security;
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
        if (isset($this->id)) {
            //$components=($this->components && count($this->components))?ComponentPermissionsResource::collection($this->components):[];
            $components = null;
            $parentComponents = [];
            //$parentSubmodules=[];

            if (!ApiRequest::startsWith($this->tag, 'config1')) {
                $components = $this->components()->orderBy('name')->get();
                $components = ($components && count($components)) ? ComponentPermissionsResource::collection($components) : [];
            } else {
                //Get setup parent module tags
                // $subModules=$this->where('parent_tag',$this->tag)->orderBy('name')->get();
                // foreach($subModules as $subModule){
                //     $parentSubmodules[$subModule->parent_tag][] = new ModulePermissionsResource($$subModule);
                // }
                $components = $this->components()->orderBy('name')->get();
                foreach ($components as $component) {
                    if (!$component->parent_tag) {
                        continue;
                    }

                       //$parentModule=Module::where('tag', $component->parent_tag)->first();
                      $parentComponents[$component->parent_tag][] = new ComponentPermissionsResource($component);
                }
                //formatting display
                $components = [];
                foreach ($parentComponents as $key => $value) {
                    $parentModule = Module::where('tag', $key)->first();

                    $components[] = [
                        'id' => $parentModule->id,
                        'name' => $parentModule->name,
                        'tag' => $parentModule->tag ?? null,
                        'parent_tag' => $parentModule->parent_tag ?? null,
                        'status' => $parentModule->status,
                        'components' => $parentComponents[$key],
                        'created_at' => DateHelper::toDisplayDateTime($parentModule->created_at),
                        'updated_at' => DateHelper::toDisplayDateTime($parentModule->updated_at)
                    ];
                }
            }

            return [
                'id' => $this->id,
                'name' => $this->name,
                'tag' => $this->tag ?? null,
                'parent_tag' => $this->parent_tag ?? null,
                'status' => $this->status,
                //'submodules'=>$parentSubmodules,
                ($this->tag != 'config' ? 'components' : 'submodules') => $components,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return null;
        }
    }
}

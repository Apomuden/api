<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Role extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function modules()
    {
        return $this->hasManyThrough(
            Module::class,
            ComponentRole::class,
            'role_id',
            'id'
        );
    }

    public function synComponentToUsers($components, $detach = false)
    {
        $users = $this->users;
        foreach ($users as $user) {
            $user->syncComponents($components, $detach);
        }
    }

    public function detachModules($modules, $cascade = false)
    {
        foreach ($modules as $module) {
            $component = ComponentRole::where('role_id', $this->id)
                ->where('module_id', $module)
                ->delete();


            if ($cascade) {
                $users = $this->users;
                foreach ($users as $user) {
                    ComponentUser::where('user_id', $user->id)
                        ->where('module_id', $module)
                        ->delete();
                }
            }
        }
    }
    public function syncModules($modules, $detach = false)
    {
        $syncPayload = [];
        $payload = [];

        $modules = $modules;
        foreach ($modules as $module) {
            $module = (object) $module;
            $dbModule = Module::with('components')->where('id', $module->id)->first();
            $components = $dbModule->components;
            foreach ($components as $component) {

                if (isset($module->all)) {
                    $syncPayload[$component->id] = [
                        'all' => $module->all ?? false,
                        'add' => $module->all ?? false,
                        'view' => $module->all ?? false,
                        'edit' => $module->all ?? false,
                        'delete' => $module->all ?? false,
                        'update' => $module->all ?? false,
                        'print' => $module->all ?? false
                    ];
                }

                $syncPayload[$component->id]['module_id'] = $module->id;
                if (isset($module->add))
                    $syncPayload[$component->id]['add'] = $module->all ? $module->all : ($module->add ?? false);
                if (isset($module->view))
                    $syncPayload[$component->id]['view'] = $module->all ? $module->all : ($module->view ?? false);

                if (isset($module->edit))
                    $syncPayload[$component->id]['edit'] = $module->all ? $module->all : ($module->edit ?? false);

                if (isset($module->update))
                    $syncPayload[$component->id]['update'] = $module->all ? $module->all : ($module->update ?? false);

                if (isset($module->delete))
                    $syncPayload[$component->id]['delete'] = $module->all ? $module->all : ($module->delete ?? false);

                if (isset($module->print))
                    $syncPayload[$component->id]['print'] = $module->all ? $module->all : ($module->print ?? false);



                $componentPayload['id'] = $component->id;
                if (isset($module->all))
                    $componentPayload['all'] =  ($module->all ?? false);
                if (isset($module->add))
                    $componentPayload['add'] = $module->all ? $module->all : ($module->add ?? false);
                if (isset($module->view))
                    $componentPayload['view'] = $module->all ? $module->all : ($module->view ?? false);
                if (isset($module->edit))
                    $componentPayload['edit'] = $module->all ? $module->all : ($module->edit ?? false);
                if (isset($module->update))
                    $componentPayload['update'] = $module->all ? $module->all : ($module->update ?? false);
                if (isset($component->delete))
                    $componentPayload['delete'] = $module->all ? $module->all : ($module->delete ?? false);
                if (isset($module->print))
                    $componentPayload['print'] = $module->all ? $module->all : ($module->print ?? false);

                $payload[] = $componentPayload;
            }
        }
        $this->components()->sync($syncPayload, $detach);
        $this->synComponentToUsers($payload, $detach);
    }

    public function syncComponents($components, $detach = false)
    {
        $syncPayload = [];
        $payload = [];

        foreach ($components as $component) {
            $component = (object) $component;
            $dbcomponent = ComponentModule::where('component_id', $component->id)->first();
            if (!$dbcomponent)
                continue;

            if (isset($component->all)) {
                $syncPayload[$component->id] = [
                    'all' => $component->all ?? false,
                    'add' => $component->all ?? false,
                    'view' => $component->all ?? false,
                    'edit' => $component->all ?? false,
                    'update' => $component->all ?? false,
                    'delete' => $component->all ?? false,
                    'print' => $component->all ?? false,
                ];
            }

            $syncPayload[$component->id]['module_id'] = $dbcomponent->module_id;

            if (isset($component->add))
                $syncPayload[$component->id]['add'] = $component->all ? $component->all : ($component->add ?? false);
            if (isset($component->view))
                $syncPayload[$component->id]['view'] = $component->all ? $component->all : ($component->view ?? false);
            if (isset($component->edit))
                $syncPayload[$component->id]['edit'] = $component->all ? $component->all : ($component->edit ?? false);
            if (isset($component->update))
                $syncPayload[$component->id]['update'] = $component->all ? $component->all : ($component->update ?? false);
            if (isset($component->delete))
                $syncPayload[$component->id]['delete'] = $component->all ? $component->all : ($component->delete ?? false);
            if (isset($component->print))
                $syncPayload[$component->id]['print'] = $component->all ? $component->all : ($component->print ?? false);


            $componentPayload['id'] = $component->id;
            if (isset($component->all))
                $componentPayload['all'] =  ($component->all ?? false);
            if (isset($component->add))
                $componentPayload['add'] = $component->all ? $component->all : ($component->add ?? false);
            if (isset($component->edit))
                $componentPayload['edit'] = $component->all ? $component->all : ($component->edit ?? false);
            if (isset($component->view))
                $componentPayload['view'] = $component->all ? $component->all : ($component->view ?? false);
            if (isset($component->update))
                $componentPayload['update'] = $component->all ? $component->all : ($component->update ?? false);
            if (isset($component->delete))
                $componentPayload['delete'] = $component->all ? $component->all : ($component->delete ?? false);
            if (isset($component->print))
                $componentPayload['print'] = $component->all ? $component->all : ($component->print ?? false);

            $payload[] = $componentPayload;
        }
        $this->components()->sync($syncPayload, $detach);
        $this->synComponentToUsers($payload, $detach);
    }
    public function detachComponents($components, $cascade = false)
    {
        foreach ($components as $component) {
            ComponentRole::where('role_id', $this->id)
                ->where('component_id', $component)
                ->delete();

            if ($cascade) {
                $users = $this->users;
                foreach ($users as $user) {
                    ComponentUser::where('user_id', $user->id)
                        ->where('component_id', $component)
                        ->delete();
                }
            }
        }
    }
}

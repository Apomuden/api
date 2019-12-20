<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class,ComponentModule::class,'component_id','component_id','id','component_id');
    }
}

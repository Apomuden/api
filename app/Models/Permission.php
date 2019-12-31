<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use ActiveTrait,SortableTrait,FindByTrait;
    protected $guarded = [];
    public $preserveKeys = true;
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

  public function component()
  {
      return $this->belongsTo(Component::class);
  }

    public function scopeModules($query)
    {
        return $query->rightJoin('component_module','permissions.component_id','=','component_module.component_id')
                     ->rightJoin('modules','modules.id','=','component_module.module_id')
                     ->distinct();

    }
}

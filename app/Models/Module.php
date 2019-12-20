<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }

   public function permissions()
   {
       return $this->hasManyThrough(
           Permission::class,
           ComponentModule::class,
           'module_id',
           'component_id',
           'id',
           'component_id',
       );
   }
}

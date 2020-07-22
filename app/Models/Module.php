<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'component_role')->distinct();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'component_user')->distinct();
    }

    /* public function roles()
   {
      return $this->hasManyThrough(
          Role::class,
          ComponentRole::class,
            'module_id',
            'id',
            'id',
            'role_id',

        )->distinct();
   } */
}

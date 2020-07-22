<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

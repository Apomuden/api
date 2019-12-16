<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use ActiveTrait;
    protected $guarded = [];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

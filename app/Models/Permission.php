<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use ActiveTrait;
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
}

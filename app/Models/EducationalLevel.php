<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class EducationalLevel extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

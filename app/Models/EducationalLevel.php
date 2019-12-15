<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class EducationalLevel extends Model
{
    use ActiveTrait;
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class StaffCategory extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }
}

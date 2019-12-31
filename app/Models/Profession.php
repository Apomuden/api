<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];

    public function staff_category()
    {
        return $this->belongsTo(StaffCategory::class);
    }
}

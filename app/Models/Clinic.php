<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function service_categories()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

}

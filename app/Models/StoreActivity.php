<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreActivity extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}

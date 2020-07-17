<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreActivity extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function store()
    {
        return $this->belongsToOne(Store::class);
    }
}

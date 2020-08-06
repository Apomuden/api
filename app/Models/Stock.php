<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;
    use SortableTrait;

    protected $guarded = [];

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function product()
    {
        return $this->hasOne(Products::class);
    }
}

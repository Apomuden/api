<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockAdjustmentProduct extends AuditableModel
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}

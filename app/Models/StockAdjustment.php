<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Http\Traits\ReferenceNumberGeneratorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class StockAdjustment extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes, ReferenceNumberGeneratorTrait;

    public static function boot() {
        parent::boot();

        static::creating(function($model){
            $model->reference_number = $model->reference_number??ReferenceNumberGeneratorTrait::generate($model->getModel());
            $model->adjusted_by = Auth::id();
        });
    }

    public function user_approved() {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function user_requested() {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function stock_adjustment_product() {
        return $this->hasMany(StockAdjustmentProduct::class, 'reference_number');
    }
}

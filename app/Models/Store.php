<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $receipt = $model->only(['patient_id','patient_status']);
            $model->receipt_number = $receipt['receipt_number']??null;
            unset($receipt);
            //dd($model);
        });
    }

    public function store_activities()
    {
        return $this->hasOne(StoreActivity::class);
    }

}

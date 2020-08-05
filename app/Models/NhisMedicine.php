<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhisMedicine extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            //updating existing products with nhis_medicine_id
                Products::whereNhisCode($model->code)
                    ->update(['nhis_medicine_id' => $model->id]);
        });
        static::updated(function ($model) {
            //updating existing products with nhis_medicine_id
            if($model->isDirty('code'))
                Products::whereNhisMedicineId($model->id)
                ->update(['nhis_code' => $model->code]);


            if($model->isDirty('price')){
                  //affected product
                $product=$model->products()->where('nhis_code', $model->code)->first();
                if($product){
                   $lastPrice=$product->product_prices()->orderBy('created_at', 'desc')->first();
                   if($lastPrice)
                   $lastPrice->nhis_amount=$model->price;
                }
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }


    public function nhis_medicines()
    {
        return $this->morphToMany(EpisodeServiceAndProduct::class, 'serviceable');
    }
}

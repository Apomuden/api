<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProductPrice extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by_id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class,'updated_by_id');
    }

    public function product_form_unit()
    {
        return $this->belongsTo(ProductFormUnit::class);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    //Mutators
    public function setProductIdAttribute($value){
        $this->attributes['product_id']=$value;
        $this->attributes['product_type_id']=$this->product->product_type_id;
        $this->attributes['product_category_id']=$this->product->product_category_id;
        $this->attributes['product_form_unit_id']=$this->product->product_form_unit_id;
        $this->attributes['nhis_amount']=$this->product->nhis_medicine->price??0.00;
    }

    public function setCurrentUnitCostAttribute($value){
        $this->attributes['current_unit_cost'] = is_numeric($value) ? $value : 0;

        $this->attributes['variance_unit_cost']= $this->current_unit_cost-($this->previous_unit_cost??0);
    }

    public function setPreviousUnitCostAttribute($value){
        $this->attributes['previous_unit_cost'] = is_numeric($value)?$value:0;

        $this->attributes['variance_unit_cost']= ($this->current_unit_cost??0)-$this->previous_unit_cost;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by_id= Auth::guard('api')->user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by_id = Auth::guard('api')->user()->id;
        });
    }
}

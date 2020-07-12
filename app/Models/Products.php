<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_form()
    {
        return $this->belongsTo(ProductForm::class);
    }

    public function product_form_unit()
    {
        return $this->belongsTo(ProductFormUnit::class);
    }

    public function medicine_route()
    {
        return $this->belongsTo(MedicineRoute::class);
    }
}

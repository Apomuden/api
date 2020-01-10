<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    use ActiveTrait,SortableTrait,FindByTrait;
    protected $guarded = [];

    public function  getDisplayNameAttribute(){
        if($this->description)
           return $this->description;
        else
            return $this->service_subcategory->name??$this->service_category->name;
    }

    public function hospital_service()
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function service_subcategory()
    {
        return $this->belongsTo(ServiceSubcategory::class);
    }

    public function funding_type()
    {
        return $this->belongsTo(FundingType::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function consultation()
    {
        return $this->hasMany(Consultation::class);
    }

}

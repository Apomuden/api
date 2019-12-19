<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class ServiceSubcategory extends Model
{
   use ActiveTrait;
   protected $guarded = [];

   public function hospital_service()
   {
       return $this->belongsTo(HospitalService::class);
   }

   public function service_category()
   {
       return $this->belongsTo(ServiceCategory::class);
   }
}

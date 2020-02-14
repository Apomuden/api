<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicService extends Model
{
    use SoftDeletes, ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function main_clinic()
    {
        return $this->belongsTo(ServiceCategory::class,'main_clinic_id');
    }

    /*public function consultation_service()
    {
        return $this->belongsTo(ServiceSubcategory::class, 'consultation_service_id');
    } */

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
           $repository=new RepositoryEloquent(new Clinic);
           $clinic=$repository->find($model->clinic_id);
           $model->main_clinic_id=$clinic->main_clinic_id;
        });

        static::updating(function ($model) {
            $repository = new RepositoryEloquent(new Clinic);
            $clinic = $repository->find($model->clinic_id);
            $model->main_clinic_id = $clinic->main_clinic_id;
        });
    }
}

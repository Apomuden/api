<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicService extends AuditableModel
{
    use SoftDeletes;
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;

    protected $guarded = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class);
    }
    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
    public function service_subcategory()
    {
        return $this->belongsTo(ServiceSubcategory::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $repository = new RepositoryEloquent(new Service());
            $service = $repository->find($model->service_id);
            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;

            $repository = new RepositoryEloquent(new Clinic());
            $clinic = $repository->find($model->clinic_id);
            $model->clinic_type_id = $clinic->clinic_type_id;
        });

        static::updating(function ($model) {
            $repository = new RepositoryEloquent(new Service());
            $service = $repository->find($model->service_id);
            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;

            $repository = new RepositoryEloquent(new Clinic());
            $clinic = $repository->find($model->clinic_id);
            $model->clinic_type_id = $clinic->clinic_type_id;
        });
    }

    public function consultation_components()
    {
        return $this->belongsToMany(ConsultationComponent::class, 'clinic_services_consultation_components')->withPivot(['created_at', 'updated_at']);
    }

    public function consultation_questions()
    {
        return $this->belongsToMany(ConsultationQuestion::class, 'clinic_services_consultation_questions')->withPivot(['order', 'created_at', 'updated_at']);
    }
}

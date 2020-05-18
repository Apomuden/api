<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Investigation extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $consultationEloquent = new RepositoryEloquent(new Consultation);
            $consultation = $consultationEloquent->find($model->consultation_id);

            $model->clinic_type_id = $consultation->clinic_type_id ?? null;
            $model->clinic_id = $consultation->clinic_id ?? null;

            $patient = $consultation->patient ?? Patient::findOrFail($model->patient_id);
            $model->patient_id = $patient->id;

            if ($model->billing_sponsor_id) {
                $billing_sponsor = BillingSponsor::findOrFail($model->billing_sponsor_id);
                $patient->sponsorship_type = $billing_sponsor->sponsorship_type;
                $patient->funding_type = FundingType::where('name', $patient->sponsorship_type->name ?? null)->first() ?? $patient->funding_type;
            } else {
                $billing_sponsor = $consultation->billing_sponsor;
                $model->billing_sponsor_id = $model->billing_sponsor_id ?? $consultation->billing_sponsor_id;
            }

            if ($model->funding_type_id) {
                $patient->funding_type = FundingType::findOrFail($model->funding_type_id);
            }

            $model->age = $model->age ?? Carbon::parse($patient->dob)->age;
            $model->age_group_id = $consultation->age_group_id;

            $model->age_category_id = $consultation->age_category_id;
            $model->age_class_id = $consultation->age_class_id;

            $model->gender = $model->gender ?? $patient->gender;
            $model->patient_status = $model->patient_status ?? $consultation->patient_status;

            $serviceEloquent = new RepositoryEloquent(new Service);
            $service = $serviceEloquent->findOrFail($model->service_id);

            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;


            $user = Auth::guard('api')->user();
            $model->user_id = $model->user_id ?? $user->id;

            $model->consultant_id = $model->consultant_id ?? $consultation->consultant_id;

            $model->funding_type_id = $model->funding_type_id ?? $patient->funding_type_id;

            $model->sponsorship_type_id = $model->sponsorship_type_id ?? $patient->sponsorship_type_id;


            if ($model->order_type == 'INTERNAL') {
                if (ucwords($patient->funding_type->name) == 'Cash/Prepaid') {
                    $model->billing_sponsor_id = null;
                    $model->sponsorship_type_id = $patient->funding_type->sponsorship_type_id;
                    $model->prepaid_total = $service->prepaid_amount;
                } else
                    $model->postpaid_total = $service->postpaid_amount;
            }

            $model->consultation_date = $model->consultation_date ?? ($consultation->started_at ?? Carbon::today());

            $policy = $patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                $query->where('status', 'ACTIVE');
            })->orderBy('priority', 'asc')->first();

            $model->sponsorship_policy_id = $model->postpaid_total ? ($policy->sponsorship_policy_id ?? null) : null;
        });

        static::created(function ($model) {
            $model->service_fee = ($model->prepaid_total ?? $model->postpaid_total) ?? 0.00;
            $model->service_quantity = 1;
            $model->service_date = $model->created_at;
            $model->prepaid = boolval($model->prepaid_total);
            $model->billing_system_id = $model->consultation->billing_sponsor->billing_system_id ?? $model->consultation->funding_type->billing_system_id;
            $model->billing_cycle_id = $model->consultation->billing_sponsor->billing_cycle_id ?? $model->consultation->funding_type->billing_cycle_id;
            $model->payment_style_id = $model->consultation->billing_sponsor->payment_style_id ?? $model->consultation->funding_type->payment_style_id;
            $model->payment_channel_id = $model->consultation->billing_sponsor->payment_channel_id ?? $model->consultation->funding_type->payment_channel_id;

            ServiceOrder::create($model->only([
                'patient_id',
                'clinic_id',
                'age',
                'gender',
                'patient_status',
                'service_id',
                'service_fee',
                'service_quantity',
                'service_date',
                'order_type',
                //'orderer_id',
                'prepaid',
                //'paid_service_price',
                //'paid_service_quantity',
                'funding_type_id',
                'billing_system_id',
                'billing_cycle_id',
                'payment_style_id',
                'payment_channel_id',
                //'insured',
                'billing_sponsor_id'
            ]));
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();

            $consultationEloquent = new RepositoryEloquent(new Consultation);
            $consultation = $consultationEloquent->find($model->consultation_id ?? $original->id);

            $model->clinic_type_id = $consultation->clinic_type_id ?? null;
            $model->clinic_id = $consultation->clinic_id ?? null;

            $patient = $consultation->patient ?? Patient::findOrFail($model->patient_id);
            $model->patient_id = $patient->id;

            if ($model->billing_sponsor_id) {
                $sponsorship_type = BillingSponsor::findOrFail($model->billing_sponsor_id);
                $patient->sponsorship_type = $sponsorship_type;
                $patient->funding_type = FundingType::where('name', $patient->sponsorship_type->name ?? null)->first() ?? $patient->funding_type;
            }

            if ($model->funding_type_id)
                $patient->funding_type = FundingType::findOrFail($model->funding_type_id);

            $model->age = $model->age ?? Carbon::parse($patient->dob)->age;



            $model->gender = $model->gender ?? $original->gender;
            $model->patient_status = $model->patient_status ?? $original->patient_status;

            if ($model->service_id) {
                $serviceEloquent = new RepositoryEloquent(new Service);
                $service = $serviceEloquent->findOrFail($model->service_id);

                $model->hospital_service_id = $service->hospital_service_id;
                $model->service_category_id = $service->service_category_id;
                $model->service_subcategory_id = $service->service_subcategory_id;
            }

            $user = Auth::guard('api')->user();
            $model->user_id = $user->id;

            $model->billing_sponsor_id = $model->billing_sponsor_id ?? ($original->billing_sponsor_id ?? null);
            if ($model->order_type == 'INTERNAL') {
                if (ucwords($patient->funding_type->name) == 'Cash/Prepaid') {
                    $model->billing_sponsor_id = null;
                    $model->sponsorship_type_id = $patient->funding_type->sponsorship_type_id;
                    $model->prepaid_total = $service->prepaid_amount;
                } else
                    $model->postpaid_total = $service->postpaid_amount;
            }

            if ($model->postpaid_total) {
                $policy = $patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                    $query->where('status', 'ACTIVE');
                })->orderBy('priority', 'asc')->first();

                $model->sponsorship_policy_id = $policy->sponsorship_policy_id ?? ($original->sponsorship_policy_id ?? null);
            }

            $model->cancelled_date = $model->canceller_id ? ($model->cancelled_date ?? Carbon::today()) : null;

            if ($model->cancelled_date)
                $model->canceller_id = $model->canceller_id ?? Auth::guard('api')->user()->id;
        });
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class);
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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funding_type()
    {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function sponsorship_policy()
    {
        return $this->belongsTo(SponsorshipPolicy::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function age_category()
    {
        return $this->belongsTo(AgeCategory::class);
    }

    public function age_classification()
    {
        return $this->belongsTo(AgeClassification::class, 'age_class_id');
    }

    public function canceller()
    {
        return $this->belongsTo(User::class, 'canceller_id');
    }

    public function lab_test_results()
    {
        return $this->hasMany(LabTestResult::class);
    }

    public function lab_test_samples()
    {
        return $this->hasMany(LabTestSample::class);
    }
}

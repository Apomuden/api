<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceOrder extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function service_orderable()
    {
        return $this->morphTo();
    }
    public function ereceipt()
    {
        return $this->morphToMany(Ereceipt::class, 'receipt_item');
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

    public function billing_system()
    {
        return $this->belongsTo(BillingSystem::class);
    }

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }

    public function payment_style()
    {
        return $this->belongsTo(PaymentStyle::class);
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class);
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

    public function orderer()
    {
        return $this->belongsTo(User::class, 'orderer_id');
    }
    public function canceller()
    {
        return $this->belongsTo(User::class, 'canceller_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $clinicEloquent = new RepositoryEloquent(new Clinic());
            $clinic = $clinicEloquent->findOrFail($model->clinic_id);
            $model->clinic_type_id = $clinic->clinic_type_id;

            $patientEloquent = new RepositoryEloquent(new Patient());
            $patient = $patientEloquent->findOrFail($model->patient_id);

            $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

            $model->gender = $model->gender ?? $patient->gender;
            $serviceEloquent = new RepositoryEloquent(new Service());
            $service = $serviceEloquent->findOrFail($model->service_id);

            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;
            $model->service_total_amt = ($model->service_fee ?? 0) * ($model->service_quantity ?? 0);
            $model->service_date = $model->service_date ? Carbon::parse($model->service_date) : Carbon::now();
            $user = Auth::guard('api')->user();
            $model->user_id = $user->id;

            $model->orderer_id = $model->orderer_id ?? $model->user_id;

            $model->prepaid = $model->prepaid ?? strtoupper($patient->funding_type->name) == 'CASH/PREPAID';
            $model->paid_service_total_amt = ($model->paid_service_price ?? 0) * ($model->paid_service_quantity ?? 0);
            $model->funding_type_id = $model->funding_type_id ?? $patient->funding_type_id;
            $model->billing_system_id = $model->billing_system_id ?? $patient->billing_system_id;
            $model->billing_cycle_id = $model->billing_cycle_id ?? $patient->billing_cycle_id;
            $model->payment_style_id = $model->payment_style_id ?? $patient->payment_style_id;
            $model->payment_channel_id = $model->payment_channel_id ?? $patient->payment_channel_id;

            $sponsorEloquent = new RepositoryEloquent(new BillingSponsor());
            $sponsor = $sponsorEloquent->find($model->billing_sponsor_id);
            $model->sponsorship_type_id = $sponsor->sponsorship_type_id ?? null;
            $model->cancelled_date = $model->canceller_id ? Carbon::today() : null;

            $policy = $patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                $query->where('status', 'ACTIVE');
            })->orderBy('priority', 'asc')->first();

            $model->sponsorship_policy_id = $model->sponsorship_policy_id ?? ($policy->sponsorship_policy_id ?? null);

            //$patient = $model->patient;
            //$model->age = $model->age ?? Carbon::parse($patient->dob)->age;

            //Nhis Pricinng
            if($model->service_orderable_type!= 'App\Models\Consultation' && strtolower(request('sponsorship_type'))!='patient'){
                $PatientActiveNhis = $patient->patient_sponsors();

                if (isset($model->billing_sponsor_id))
                    $PatientActiveNhis = $PatientActiveNhis->where('billing_sponsor_id', $model->billing_sponsor_id);

                $PatientActiveNhis = $PatientActiveNhis->whereHas('billing_sponsor', function ($q1) {
                    $q1->whereHas('sponsorship_type', function ($q2) {
                        $q2->whereName('Government Insurance');
                    });
                })->where('expiry_date', '>=', today())->first();

                if ($PatientActiveNhis) {
                    $nhisSettings = NhisAccreditationSetting::first();
                    if ($model->age > 12) {
                        $model->service_fee = $model->service->nhis_adult_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    } else {
                        $model->service_fee = $model->service->nhis_child_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    }
                }

                $model->service_total_amt = $model->service_fee * $model->service_quantity;
            }
            //if ($model->patient_status)
            //$model->patient->update(['reg_status' => $model->patient_status]);
        });

        static::updating(function ($model) {
            $original = $model->getOriginal();

            $clinicEloquent = new RepositoryEloquent(new Clinic());
            $clinic = $clinicEloquent->find($model->clinic_id) ?? ($original->clinic ?? null);
            $model->clinic_type_id = $clinic->clinic_type_id;

            $patientEloquent = new RepositoryEloquent(new Patient());
            $patient = $patientEloquent->find($model->patient_id) ?? ($original->patient ?? null);

            $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

            if($model->isDirty('gender'))
            $model->gender = $model->gender;

            if($model->isDirty('service_id')){
                $serviceEloquent = new RepositoryEloquent(new Service());
                $service = $serviceEloquent->find($model->service_id) ?? ($original->service ?? null);
            }
            else
                $service = $original->service;

            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;

            $model->service_total_amt = (($model->service_fee ?? $original->service_fee) ?? 0) * (($model->service_quantity ?? $original->service_quantity) ?? 0);

            $model->service_date = $model->service_date ? Carbon::parse($model->service_date ?? null) : ($original->service_date ?? null);
            //$user = Auth::guard('api')->user();
            //$model->user_id = $user->id;


            $model->prepaid = ($model->prepaid ?? ($original->prepaid ?? null)) ?? $patient->funding_type->name == 'Cash/Prepaid';


            $model->paid_service_total_amt = ($model->paid_service_price ?? ($original->paid_service_price) ?? null) * ($model->paid_service_quantity ?? ($original->paid_service_quantity) ?? null);
            $model->funding_type_id = $model->funding_type_id ?? $patient->funding_type_id;


            $model->billing_system_id = $model->billing_system_id ?? $patient->billing_system_id;
            $model->billing_cycle_id = $model->billing_cycle_id ?? $patient->billing_cycle_id;
            $model->payment_style_id = $model->payment_style_id ?? $patient->payment_style_id;
            $model->payment_channel_id = $model->payment_channel_id ?? $patient->payment_channel_id;

            $sponsorEloquent = new RepositoryEloquent(new BillingSponsor());
            $sponsor = $sponsorEloquent->find($model->billing_sponsor_id) ?? ($original->billing_sponsor ?? null);
            $model->sponsorship_type_id = $sponsor->sponsorship_type_id ?? ($original->sponsorship_type_id) ?? null;
            $model->cancelled_date = $model->canceller_id ? Carbon::today() : ($original->cancelled_date ?? null);


            //Nhis Pricinng
            if($model->service_orderable_type != 'App\Models\Consultation' && $model->isDirty('billing_sponsor_id') && strtolower(request('sponsorship_type')) != 'patient'){
                $PatientActiveNhis = $patient->patient_sponsors();

                if (isset($model->billing_sponsor_id))
                    $PatientActiveNhis = $PatientActiveNhis->where('billing_sponsor_id', $model->billing_sponsor_id);

                $PatientActiveNhis = $PatientActiveNhis->whereHas('billing_sponsor', function ($q1) {
                    $q1->whereHas('sponsorship_type', function ($q2) {
                        $q2->whereName('Government Insurance');
                    });
                })->where('expiry_date', '>=', today())->first();

                if ($PatientActiveNhis) {
                    $nhisSettings = NhisAccreditationSetting::first();
                    if ($model->age > 12) {
                        $model->service_fee = $model->service->nhis_adult_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    } else {
                        $model->service_fee = $model->service->nhis_child_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    }
                }

                $model->service_total_amt = $model->service_fee * $model->service_quantity;
            }

            //if ($model->isDirty('patient_status'))
            //$model->patient->update(['reg_status' => $model->patient_status]);
        });
    }
}

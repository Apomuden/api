<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Helpers\Notify;
use App\Http\Requests\Setups\NhisAccreditationSettingRequest;
use App\Http\Resources\Registrations\ConsultationResource;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Models\Obstetrics\ObstetricQuestionResponse;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Consultation extends AuditableModel
{
    use SoftDeletes;
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
                $user = Auth::guard('api')->user();
                $model->user_id = $user->id;

                //get patient details
                //$repository = new RepositoryEloquent(new Patient());
                //$patient = $repository->find($model->patient_id);
                $patient = $model->patient;
                $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

                //Nhis Pricinng
                $PatientActiveNhis = null;
                if (strtolower(request('sponsorship_type')) != 'patient') {
                    $PatientActiveNhis = $patient->patient_sponsors();
                    if (isset($model->billing_sponsor_id))
                        $PatientActiveNhis = $PatientActiveNhis->where('billing_sponsor_id', $model->billing_sponsor_id);

                    $PatientActiveNhis = $PatientActiveNhis->whereHas('billing_sponsor', function ($q1) {
                        $q1->whereHas('sponsorship_type', function ($q2) {
                            $q2->whereName('Government Insurance');
                        });
                    })->where('expiry_date', '>=', today())->first();
                }
                if ($PatientActiveNhis) {
                    $nhisSettings = NhisAccreditationSetting::first();
                    if ($model->age > 12) {
                        $model->service_fee = $model->service->nhis_adult_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    } else {
                        $model->service_fee = $model->service->nhis_child_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                    }
                }

                //age class and group
                $repository = new RepositoryEloquent(new AgeClassification());
                $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUTPATIENT'])->orWhere('name', 'GHS REPORTS')->first();

                $age_category = DateHelper::getAgeCategory($age_class->id ?? null, $model->age ? DateHelper::getDOB($model->age) : $patient->dob);
                $model->age_group_id = $age_category->age_group_id ?? null;
                $model->attendance_date = $model->attendance_date ?? Carbon::now();
                $model->age_class_id = $age_category->age_classification_id;
                $model->age_category_id = $age_category->id;

        });
        static::created(function ($model) {
            try {
            //create an attendance
            $model->service_id = $model->consultation_service_id ?? null;

            unset($model->card_serial_no);
            unset($model->order_type);
            unset($model->consultation_given);
            unset($model->member_id);
            unset($model->ccc);
            unset($model->staff_id);
            unset($model->consultation_service_id);
            unset($model->user_id);
            unset($model->started_at);
            unset($model->status);

            $model->sponsor_id = $model->billing_sponsor_id;
            $model->services_orders()->create($model->only([
                'patient_id',
                'clinic_id',
                'age',
                'gender',
                'patient_status',
                'service_id',
                'service_fee',
                'service_quantity',
                'service_date',
                //'order_type',
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


            unset($model->service_fee);
            unset($model->service_quantity);
            unset($model->billing_sponsor_id);
            unset($model->patient_sponsor_id);

            //Trigger Notification
            if ($model->consultant_id) {
                Notify::send('consultation', $model->consultant_id, new ConsultationResource($model));
            }

            unset($model->consultant_id);

                if (!DateHelper::hasAttendedToday($model->patient_id, $model->clinic_id, $model->service_id)) {
                    unset($model->pregnant,$model->patient);
                    Attendance::create($model->toArray());

                }
            } catch (Exception $e) {
                Log::alert('Consultation Model',[$e->getMessage()]);
            }
        });

        static::updating(function ($model) {
            //if($model->isDirty('consultation_service_id')){
                //get patient details
                //$repository = new RepositoryEloquent(new Patient());
                //$patient = $repository->find($model->patient_id);
                $patient = $model->patient;
                $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

                //Nhis Pricinng
                $PatientActiveNhis=null;
                if($model->isDirty('billing_sponsor_id') && strtolower(request('sponsorship_type')) != 'patient'){
                    $PatientActiveNhis = $patient->patient_sponsors();

                    if(isset($model->billing_sponsor_id))
                    $PatientActiveNhis= $PatientActiveNhis->where('billing_sponsor_id', $model->billing_sponsor_id);

                    $PatientActiveNhis= $PatientActiveNhis->whereHas('billing_sponsor', function ($q1) {
                        $q1->whereHas('sponsorship_type', function ($q2) {
                            $q2->whereName('Government Insurance');
                        });
                    })->where('expiry_date', '>=', today())->first();
                }


            if ($PatientActiveNhis) {
                $nhisSettings = NhisAccreditationSetting::first();
                if ($model->age > 12) {
                    $model->service_fee = $model->service->nhis_adult_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                } else {
                    $model->service_fee = $model->service->nhis_child_tariff->nhis_provider_level_tariffs()->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? ($model->service_fee ?? $model->service->postpaid_amount);
                }
            }
            //}
        });
        static::updated(function ($model) {

            //update service order
            $model->service_id = $model->consultation_service_id ?? null;

            if($model->funding_type)
            $model->prepaid=strtoupper($model->funding_type->name)==strtoupper('Cash/Prepaid');

            $model->services_orders()->whereServiceId($model->consultation_service_id)->update($model->only([
                'patient_id',
                'clinic_id',
                'age',
                'patient_status',
                'service_id',
                'service_fee',
                'service_quantity',
                'service_date',
                //'order_type',
                //'orderer_id',
                'prepaid',
                //'paid_service_price',
                //'paid_service_quantity',
                'funding_type_id',
                //'billing_system_id',
                //'billing_cycle_id',
                //'payment_style_id',
                //'payment_channel_id',
                //'insured',
                'billing_sponsor_id'
            ]));
            //update an attendance
            $repository = new RepositoryEloquent(new Attendance());
            $model->attendance_id = $repository
                    ->getModel()
                    ->where('patient_id', $model->patient_id ?? $model->getOriginal('patient_id'))
                    ->where('clinic_id', $model->clinic_id ?? $model->getOriginal('clinic_id'))
                    ->where('service_id', $model->consultation_service_id ?? $model->getOriginal('consultation_service_id'))
                    ->whereDate('attendance_date', Carbon::parse($model->attendance_date ?? $model->getOriginal('attendance_date')))
                    ->orderBy('created_at', 'desc')->first()->id ?? null;

            Attendance::updateObject($model);
            //Trigger Notification
            if ($model->consultant_id && $model->consultant_id != $model->getOriginal('consultant_id')) {
                Notify::send('consultation', $model->consultant_id, new ConsultationResource($model));
            }
        });
    }

    public function age_class()
    {
        return $this->belongsTo(AgeClassification::class);
    }

    public function age_category()
    {
        return $this->belongsTo(AgeCategory::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'consultation_service_id');
    }

    public function services_orders()
    {
        return $this->morphMany(ServiceOrder::class, 'service_orderable');
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

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function patient_sponsor()
    {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function responses()
    {
        return $this->hasMany(ConsultationQuestionResponse::class);
    }

    public function obstetric_question_responses()
    {
        return $this->hasMany(ObstetricQuestionResponse::class);
    }

    public function discharge_reason()
    {
        return $this->belongsTo(DischargeReason::class);
    }
}

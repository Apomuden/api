<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Helpers\Notify;
use App\Http\Resources\Registrations\ConsultationResource;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Consultation extends Model
{
    use SoftDeletes, ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $user = Auth::guard('api')->user();
            $model->user_id=$user->id;

            //get patient details
            $repository = new RepositoryEloquent(new Patient);
            $patient = $repository->find($model->patient_id);
            $model->age = Carbon::parse($patient->dob)->age;

            //age class and group
            $repository = new RepositoryEloquent(new AgeClassification);
            $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUTPATIENT'])->first();

            $age_category = DateHelper::getAgeCategory($age_class->id, $model->age ? DateHelper::getDOB($model->age) : $patient->dob);
            $model->age_group_id = $age_category->age_group_id??null;
            $model->attendance_date=$model->attendance_date??Carbon::now();
            //$model->age_class_id = $age_category->age_classification_id;
            //$model->age_category_id = $age_category->id;
        });
        static::created(function ($model) {
            //create an attendance
            $model->service_id= $model->consultation_service_id??null;

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
            if ($model->consultant_id)
                Notify::send('consultation', $model->consultant_id,new ConsultationResource($model));

            unset($model->consultant_id);

            if(!DateHelper::hasAttendedToday($model->patient_id,$model->clinic_id,$model->service_id)){
                Attendance::create($model->toArray());
            }
        });

        static::updated(function ($model) {
            //update an attendance
            $repository=new RepositoryEloquent(new Attendance);
            $model->attendance_id=$repository
            ->getModel()
            ->where('patient_id',$model->patient_id)
            ->where('clinic_id',$model->clinic_id)
            ->where('service_id', $model->consultation_service_id)
            ->whereDate('attendance_date',$model->attendance_date)
            ->lastest()->first()->id??null;

            Attendance::updateObject($model);

            //Trigger Notification
            if ($model->consultant_id && $model->consultant_id!= $model->getOriginal('consultant_id'))
                Notify::send('consultation', $model->consultant_id,new ConsultationResource($model));
        });
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'consultation_service_id');
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

}

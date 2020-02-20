<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use App\Repositories\RepositoryEloquent;
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
        });
        static::created(function ($model) {
            //create an attendance
            $service_id= $model->consultation_service_id??null;
            unset($model->consultation_given);
            unset($model->service_quantity);
            unset($model->service_fee);
            unset($model->member_id);
            unset($model->ccc);
            unset($model->staff_id);
            unset($model->consultation_service_id);
            unset($model->user_id);
            unset($model->started_at);
            unset($model->status);

          if(!DateHelper::hasAttendedToday($model->patient_id,$model->clinic_id,$service_id))
           Attendance::create($model);
        });

        static::updated(function ($model) {
            //update an attendance
            $repository=new RepositoryEloquent(new Attendance);
            $model->attendance_id=$repository
            ->getModel()
            ->where('patient_id',$model->patient_id)
            ->where('clinic_id',$model->clinic_id)
            ->whereDate('attendance_date',$model->attendance_date)
            ->lastest()->first()->id??null;

            Attendance::updateObject($model);
        });
    }
    public function consultation_service()
    {
        return $this->belongsTo(ClinicService::class, 'consultation_service_id');
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
        return $this->belongsTo(AgeGroup::class);
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

}

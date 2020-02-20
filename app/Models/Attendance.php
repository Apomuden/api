<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Attendance extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded=[];

    public static function updateObject($model){
        $attendance=self::find($model->attendance_id);
        //create an attendance
        $repository = new RepositoryEloquent(new FundingType);
        $funding_type = $repository->find($model->funding_type_id);
        $insured = in_array(ucfirst($funding_type->name), ['Cash/Prepaid', 'Cash/Prepaid', 'Cash', 'Prepaid']) ? 'NO' : 'YES';
        $attendance->patient_id = $model->parent_id;

        //get clinic details
        $repository = new RepositoryEloquent(new Clinic);
        $clinic = $repository->find($model->clinic_id);
        $attendance->clinic_type_id = $clinic->clinic_type_id;

        //get patient details
        $repository = new RepositoryEloquent(new Patient);
        $patient = $repository->findOrFail($model->patient_id);
        $attendance->age = Carbon::parse($patient->dob)->age;

        $attendance->gender = $model->gender ?? $patient->gender;

        $attendance->insured = $insured;
        $attendance->funding_type_id = $model->funding_type_id ?? null;
        $attendance->sponsor_id = $model->billing_sponsor_id ?? null;
        $attendance->sponsorship_type_id = $model->sponsorship_type_id ?? null;

        //age class and group
        $repository = new RepositoryEloquent(new AgeClassification);
        $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUT PATIENT'])->first();

        $age_category = DateHelper::getAgeCategory($age_class->id, $patient->dob);
        $attendance->age_group_id = $age_category->age_group_id;
        $attendance->age_class_id = $age_category->age_classification_id;
        $attendance->age_category_id = $age_category->id;

        $attendance->patient_status = 'OUT-PATIENT';

        $attendance->request_type = DateHelper::isNewAttendance($model->patient_id, $model->clinic_id) ? 'NEW' : 'OLD';

        $attendance->attendance_date = DateHelper::toDBDate($model->attendance_date);

        $attendance->save();
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            //create an attendance
            $repository = new RepositoryEloquent(new FundingType);
            $funding_type = $repository->find($model->funding_type_id);
            $insured = in_array(ucfirst($funding_type->name), ['Cash/Prepaid', 'Cash/Prepaid', 'Cash', 'Prepaid']) ? 'NO' : 'YES';
            $model->patient_id = $model->parent_id;

            //get clinic details
            $repository = new RepositoryEloquent(new Clinic);
            $clinic=$repository->find($model->clinic_id);
            $model->clinic_type_id=$clinic->clinic_type_id;

            //get patient details
            $repository=new RepositoryEloquent(new Patient);
            $patient=$repository->find($model->patient_id);
            throw new Exception(json_encode($patient));
            $model->age = Carbon::parse($patient->dob)->age;

            $model->gender=$model->gender??$patient->gender;

            $model->insured = $insured;
            $model->funding_type_id = $model->funding_type_id??null;
            $model->sponsor_id = $model->billing_sponsor_id??null;
            $model->sponsorship_type_id = $model->sponsorship_type_id??null;

            //age class and group
            $repository = new RepositoryEloquent(new AgeClassification);
            $age_class=$repository->findWhere(['name'=> 'GHS STATEMENT OF OUT PATIENT'])->first();

            $age_category=DateHelper::getAgeCategory($age_class->id, $patient->dob);
            $model->age_group_id=$age_category->age_group_id;
            $model->age_class_id=$age_category->age_classification_id;
            $model->age_category_id=$age_category->id;

            $model->patient_status= 'OUT-PATIENT';

            $model->request_type=DateHelper::isNewAttendance($model->patient_id,$model->clinic_id)?'NEW':'OLD';

            $model->attendance_date=DateHelper::toDBDate($model->attendance_date);

        });

        static::updating(function ($model) {
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

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
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
        return $this->belongsTo(BillingSponsor::class,'sponsor_id');
    }
    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class);
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}

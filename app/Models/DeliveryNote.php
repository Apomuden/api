<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DeliveryNote extends AuditableModel
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];
    public function age_class()
    {
        return $this->belongsTo(AgeClassification::class, 'age_class_id');
    }

    public function age_category()
    {
        return $this->belongsTo(AgeCategory::class);
    }
    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::guard('api')->user();
            $model->user_id = $user->id;

            $consultation = $model->consultation;
            if ($consultation && !$model->patient_id) {
                $model->patient_id = $consultation->patient_id;
            }

            $model->clinic_type_id = $consultation->clinic_type_id ?? null;
            $model->clinic_id = $consultation->clinic_id ?? null;

            $patient = $model->patient;
            $model->gender = $patient->gender;

            if ($consultation) {
                $model->billing_sponsor_id = $consultation->billing_sponsor_id;
                $model->sponsorship_policy_id = $consultation->sponsorship_policy_id;
                $model->sponsorship_type_id = $consultation->sponsorship_type_id;
                $model->funding_type_id = $consultation->funding_type_id;
                $model->age_category_id = $consultation->age_category_id;
                $model->age_class_id = $consultation->age_class_id;
                $model->age_group_id = $consultation->age_group_id;
                $model->consultation_date = $consultation->start_date;
                $model->age = $consultation->age;
            } else {
                $patient_sponsor = $patient->patient_sponsors()->orderBy('priority', 'asc')->first();
                $model->billing_sponsor_id = $patient_sponsor->billing_sponsor_id ?? null;
                $model->sponsorship_policy_id = $patient_sponsor->sponsorship_policy_id;
                $model->$model->funding_type_id = $patient_sponsor->funding_type_id ?? $patient->funding_type_id;
                $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

                //age class and group
                $repository = new RepositoryEloquent(new AgeClassification);
                $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUTPATIENT'])->orWhere('name', 'GHS REPORTS')->first();

                $age_category = DateHelper::getAgeCategory($age_class->id ?? null, $model->age ? DateHelper::getDOB($model->age) : $patient->dob);
                $model->age_group_id = $age_category->age_group_id ?? null;
                $model->age_class_id = $age_category->age_classification_id;
                $model->age_category_id = $age_category->id;
            }
            if ($model->status == 'CANCELLED') {
                $model->cancelled_date = now();
                //$user = Auth::guard('api')->user();
                $model->canceller_id = $user->id;
            }
        });
        static::created(function ($model) {
            PatientClinicalNoteSummary::updateSummary($model);
        });
        static::updating(function ($model) {
            $user = Auth::guard('api')->user();

            if ($model->isDirty('consultation_id')) {
                $consultation = $model->consultation;
                $model->patient_id = $consultation->patient_id;
                $model->gender = $consultation->patient->gender;
                $model->clinic_type_id = $consultation->clinic_type_id ?? null;
                $model->clinic_id = $consultation->clinic_id ?? null;

                $model->billing_sponsor_id = $consultation->billing_sponsor_id;
                $model->sponsorship_policy_id = $consultation->sponsorship_policy_id;
                $model->sponsorship_type_id = $consultation->sponsorship_type_id;
                $model->funding_type_id = $consultation->funding_type_id;
                $model->age_category_id = $consultation->age_category_id;
                $model->age_class_id = $consultation->age_class_id;
                $model->age_group_id = $consultation->age_group_id;
                $model->consultation_date = $consultation->start_date;
                $model->age = $consultation->age;
            } else if ($model->isDirty('patient_id')) {
                $patient = $model->patient;
                $model->gender = $patient->gender;
                $patient_sponsor = $patient->patient_sponsors()->orderBy('priority', 'asc')->first();
                $model->billing_sponsor_id = $patient_sponsor->billing_sponsor_id ?? null;
                $model->sponsorship_policy_id = $patient_sponsor->sponsorship_policy_id;
                $model->$model->funding_type_id = $patient_sponsor->funding_type_id ?? $patient->funding_type_id;
                $model->age = $model->age ?? Carbon::parse($patient->dob)->age;

                //age class and group
                $repository = new RepositoryEloquent(new AgeClassification);
                $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUTPATIENT'])->orWhere('name', 'GHS REPORTS')->first();

                $age_category = DateHelper::getAgeCategory($age_class->id ?? null, $model->age ? DateHelper::getDOB($model->age) : $patient->dob);
                $model->age_group_id = $age_category->age_group_id ?? null;
                $model->age_class_id = $age_category->age_classification_id;
                $model->age_category_id = $age_category->id;
            }
            if ($model->status == 'CANCELLED' && $model->getOriginal('status') != 'CANCELLED') {
                $model->cancelled_date = now();
                $model->canceller_id = $user->id;
            }
        });
        static::updated(function ($model) {
            PatientClinicalNoteSummary::updateSummary($model);
        });
    }
}

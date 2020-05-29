<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientClinicalNoteSummary extends Model
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

    static function updateSummary($model){
        $payload=[
              'age'=>$model->age,
              'age_group_id'=>$model->age_group_id,
              'age_class_id'=>$model->age_class_id,
            'age_category_id'=>$model->age_category_id,
            'gender'=>$model->gender,
            'patient_status'=>$model->patient_status,
            'funding_type_id'=>$model->funding_type_id,
            'sponsorship_type_id'=>$model->sponsorship_type_id,
            'billing_sponsor_id'=>$model->billing_sponsor_id,
            'sponsorship_policy_id'=>$model->sponsorship_policy_id,
            'user_id'=>$model->user_id,
        ];
        if($model instanceof TreatmentPlanNote)
        $payload['treatment_plan']=$model->notes;
        else if($model instanceof UrgentCareNote)
        $payload['urgent_care_note'] = $model->notes;
        else if($model instanceof ProgressNote)
        $payload['progress_note'] = $model->notes;
        else if($model instanceof AdmissionNote)
        $payload['admission_note'] = $model->notes;
        else if($model instanceof ProcedureNote)
        $payload['procedure_note'] = $model->notes;
        else if($model instanceof DeliveryNote)
        $payload['delivery_note'] = $model->notes;
        else if($model instanceof NursingNote)
        $payload['nursing_note'] = $model->notes;
        else if($model instanceof PhysicianNote)
        $payload['physician_note'] = $model->notes;

        self::updateOrCreate(['patient_id'=>$model->patient_id],$payload);
    }
}

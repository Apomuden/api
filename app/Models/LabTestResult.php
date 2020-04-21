<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use App\Models\LabParameterRange;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LabTestResult extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $investigation=Investigation::findOrFail($model->investigation_id);
            $patient=$investigation->patient;
            $model->patient_id = $patient->id;

            $model->billing_sponsor_id = $investigation->billing_sponsor_id;

            if($model->lab_parameter_id){
                $lab_parameter=LabParameter::findOrFail($model->lab_parameter_id);
                $model->lab_parameter_name =$lab_parameter->name;
                $model->lab_parameter_description =$lab_parameter->description;
                $model->value_type =$lab_parameter->value_type;
                $range= $model->compute_range;
                $model->lab_parameter_range_id=$range->id??null;
                $model->flag =$range->flag??null;
                $model->min_comparator =$range->min_comparator??null;
                $model->min_value =$range->min_value??null;
                $model->max_value =$range->max_value??null;
                $model->max_comparator =$range->max_comparator??null;
                $model->min_age = $range->min_age??null;
                $model->max_age = $range->max_age??null;
                $model->min_age_unit = $range->min_age_unit??null;
                $model->max_age_unit = $range->max_age_unit??null;
                $model->range_text_value = $range->text_value??null;

                $model->parameter_order = $investigation->service->lab_parameters()->where('lab_parameter_id', $lab_parameter->id)->first()->pivot->order;

            }
            $user = Auth::guard('api')->user();
            if($model->status== 'CANCELLED')
            {
                $model->canceller_id= $user->id;
                $model->cancelled_date = $model->cancelled_date??Carbon::today();
            }

            $model->age = Carbon::parse($patient->dob)->age;
            $model->age_group_id = $investigation->age_group_id;

            $model->age_category_id = $investigation->age_category_id;
            $model->age_class_id = $investigation->age_class_id;

            $model->gender = $patient->gender;
            $model->patient_status = $model->patient_status ?? $investigation->patient_status;

            $serviceEloquent = new RepositoryEloquent(new Service);
            $service = $serviceEloquent->findOrFail($investigation->service_id);

            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;
            $model->service_id=$service->id;

            $model->user_id = $model->user_id ?? $user->id;

            $model->technician_id = $model->technician_id ?? $user->id;

            $model->funding_type_id =$investigation->funding_type_id;

            $model->sponsorship_type_id = $investigation->sponsorship_type_id;

            if ($model->order_type == 'INTERNAL') {
                if (ucwords($patient->funding_type->name) == 'Cash/Prepaid') {
                    $model->billing_sponsor_id = null;
                    $model->sponsorship_type_id = $patient->funding_type->sponsorship_type_id;
                    $model->prepaid_total = $service->prepaid_amount;
                } else
                    $model->postpaid_total = $service->postpaid_amount;
            }

            $model->test_date  = $model->test_date  ??  Carbon::today();

            $policy = $patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                $query->where('status', 'ACTIVE');
            })->orderBy('priority', 'asc')->first();

            $model->sponsorship_policy_id = $model->postpaid_total ? ($policy->sponsorship_policy_id ?? null) : null;

        });

        static::created(function($model){
            $model->seedParams();
            $model->resultsCompleted();
            if($model->status=='APPROVED' && !$model->investigation->status='CANCELLED')
            {
                $model->investigation->lab_test_samples()->update(['status'=> 'APPROVED']);
                $model->investigation->update(['status' => 'APPROVED']);
            }
        });
        static::updating(function ($model) {

            $user = Auth::guard('api')->user();

            $model->user_id = $model->user_id ?? $user->id;

            $model->technician_id = $model->technician_id ?? $user->id;

            if ($model->investigation_id) {
                $investigation = Investigation::findOrFail($model->investigation_id);
                $model->service_id = $investigation->service_id;
                $model->patient_id = $investigation->patient_id;

                $model->age = Carbon::parse($investigation->patient->dob)->age;
                $model->age_group_id = $investigation->age_group_id;

                $model->age_category_id = $investigation->age_category_id;
                $model->age_class_id = $investigation->age_class_id;

                $model->gender = $investigation->patient->gender;
                $model->patient_status = $model->patient_status ?? $investigation->patient_status;

                $serviceEloquent = new RepositoryEloquent(new Service);
                $service = $serviceEloquent->findOrFail($investigation->service_id);

                $model->hospital_service_id = $service->hospital_service_id;
                $model->service_category_id = $service->service_category_id;
                $model->service_subcategory_id = $service->service_subcategory_id;
                $model->service_id = $service->id;


                $model->funding_type_id = $investigation->funding_type_id;

                $model->sponsorship_type_id = $investigation->sponsorship_type_id;

                if (ucwords($investigation->patient->funding_type->name) == 'Cash/Prepaid') {
                    $model->billing_sponsor_id = null;
                    $model->sponsorship_type_id = $investigation->patient->funding_type->sponsorship_type_id;
                    $model->prepaid_total = $service->prepaid_amount;
                } else
                    $model->postpaid_total = $service->postpaid_amount;


                $policy = $investigation->patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                    $query->where('status', 'ACTIVE');
                })->orderBy('priority', 'asc')->first()??null;

                $model->sponsorship_policy_id = $model->postpaid_total ? ($policy->sponsorship_policy_id ?? null) : null;
            }
            else
            $investigation=$model->investigation;

            if ($model->lab_parameter_id) {
                $lab_parameter = LabParameter::findOrFail($model->lab_parameter_id);
                $model->lab_parameter_name = $lab_parameter->name;
                $model->lab_parameter_description = $lab_parameter->description;
                $model->value_type = $lab_parameter->value_type;
                $range = $model->compute_range;
                $model->lab_parameter_range_id = $range->id??null;
                $model->flag = $range->flag??null;
                $model->min_comparator = $range->min_comparator??null;
                $model->min_value = $range->min_value??null;
                $model->max_value = $range->max_value??null;
                $model->max_comparator = $range->max_comparator??null;
                $model->max_value = $range->max_value??null;
                $model->min_age = $range->min_age??null;
                $model->max_age = $range->max_age??null;
                $model->min_age_unit = $range->min_age_unit??null;
                $model->max_age_unit = $range->max_age_unit??null;
                $model->range_text_value=$range->text_value??null;

                $model->parameter_order= $investigation->service->lab_parameters()->where('lab_parameter_id', $lab_parameter->id)->first()->pivot->order;
            }

            if ($model->status == 'APPROVED' && !$model->getOriginal('approval_date') && !$model->investigation->status = 'CANCELLED') {
                $model->investigation->lab_test_samples()->update(['status' => 'APPROVED']);
                $model->investigation->update(['status' => 'APPROVED']);
                $model->approver_id=$user->id;
                $model->approval_date=Carbon::today();
            }
            elseif ($model->status == 'CANCELLED') {
                    $model->canceller_id = $user->id;
                    $model->cancelled_date = $model->cancelled_date ?? Carbon::today();
                }

        });

        static::updated(function ($model) {
            $model->seedParams();
            $model->resultsCompleted();

        });
    }

    public function getComputeRangeAttribute(){
       if($this->test_value && $this->lab_parameter_id && $this->patient_id){
          $patient=Patient::withTrashed()->findOrFail($this->patient_id);
          $ranges=LabParameterRange::where('lab_parameter_id',$this->lab_parameter_id)->orderBy('max_value')->get();

          foreach($ranges as $range){
              $expression=null;
            if ($patient->abs_age && $patient->age_unit) {
                if ($range->min_age && $range->min_age_unit)
                        $expression .= $patient->ageByUnit($range->min_age_unit) . ' >= ' . $range->min_age . ' && ';
                if ($range->max_age && $range->max_age_unit)
                        $expression .= $patient->ageByUnit($range->max_age_unit) . ' <= ' . $range->max_age . ' && ';
            }
            if($range->lab_parameter->value_type== 'Text')
                $expression.=strtolower(trim($this->test_value)).' = '. strtolower(trim($range->text_value));
            else{
                if($range->min_comparator && $range->min_value)
                    $expression="$this->test_value $range->min_comparator $range->min_value && ";
                if($range->max_comparator && $range->max_value)
                    $expression.="$this->test_value $range->max_comparator $range->max_value";
            }

                $expression = rtrim($expression, ' && ');
                $inRange = eval("return $expression;");
                if ($inRange)
                    return $range;

          }
       }
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

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }
    public function technician()
    {
        return $this->belongsTo(User::class);
    }


    public function seedParams(){
       $parameters= $this->service->lab_parameters()->orderBy('lab_service_parameters.order')->get();
       foreach($parameters as $parameter){
           self::firstOrCreate([
                'investigation_id'=>$this->investigation_id,
                'lab_parameter_id'=>$parameter->id,
           ],[
                'patient_id'=>$this->patient_id
           ]);
       }
    }

    public function resultsCompleted(){
        $parameters = $this->service->lab_parameters()->orderBy('lab_service_parameters.order')->get();

        if($parameters->count()==self::whereNotIn('status',['APPROVED', 'CANCELLED', 'RESULTS-TAKEN'])->count())
           $this->investigation->update(['status'=> 'RESULTS-TAKEN']);
    }

}

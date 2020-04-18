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

            if (request('billing_sponsor_id')) {
                $billing_sponsor = BillingSponsor::findOrFail($model->billing_sponsor_id);
                $patient->sponsorship_type = $billing_sponsor->sponsorship_type;
                $patient->funding_type = FundingType::where('name', $patient->sponsorship_type->name ?? null)->first() ?? $patient->funding_type;
            } else {
                $billing_sponsor = $investigation->billing_sponsor;
                $model->billing_sponsor_id = $model->billing_sponsor_id ?? $investigation->billing_sponsor_id;
            }

            if (request('funding_type_id')) {
                $patient->funding_type = FundingType::findOrFail($model->funding_type_id);
            }

            if(request('lab_parameter_id')){
                $lab_parameter=LabParameter::findOrFail($model->lab_parameter_id);
                $model->lab_parameter_name =$lab_parameter->name;
                $model->lab_parameter_description =$lab_parameter->description;
                $model->value_type =$lab_parameter->value_type;
                $range= $model->compute_range;
                $model->lab_parameter_range_id=$range->id;
                $model->flag =$range->flag;
                $model->min_comparator =$range->min_comparator;
                $model->min_value =$range->min_value;
                $model->min_value =$range->min_value;
                $model->max_comparator =$range->max_comparator;
                $model->max_value =$range->max_value;
                $model->min_age =$range->min_age;
                $model->min_age =$range->min_age;
            }


            $user = Auth::guard('api')->user();
            if($model->status== 'CANCELLED')
            {
                $model->canceller_id= $model->canceller_id??$user->id;
                $model->cancelled_date = $model->cancelled_date??Carbon::today();
            }

            $model->age = $model->age ?? Carbon::parse($patient->dob)->age;
            $model->age_group_id = $investigation->age_group_id;

            $model->age_category_id = $investigation->age_category_id;
            $model->age_class_id = $investigation->age_class_id;

            $model->gender = $model->gender ?? $patient->gender;
            $model->patient_status = $model->patient_status ?? $investigation->patient_status;

            $serviceEloquent = new RepositoryEloquent(new Service);
            $service = $serviceEloquent->findOrFail($model->service_id);

            $model->hospital_service_id = $service->hospital_service_id;
            $model->service_category_id = $service->service_category_id;
            $model->service_subcategory_id = $service->service_subcategory_id;
            $model->service_id=$service->id;

            $model->user_id = $model->user_id ?? $user->id;

            $model->technician_id = $model->technician_id ?? $user->id;

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

            $model->test_date  = $model->test_date  ??  Carbon::today();

            $policy = $patient->patient_sponsors()->whereHas('sponsorship_policy', function ($query) {
                $query->where('status', 'ACTIVE');
            })->orderBy('priority', 'asc')->first();

            $model->sponsorship_policy_id = $model->postpaid_total ? ($policy->sponsorship_policy_id ?? null) : null;
        });

        static::updating(function ($model) {
            if ($model->investigation_id) {
                $investigation = Investigation::findOrFail($model->investigation_id);
                $model->service_id = $investigation->service_id;
                $model->patient_id = $investigation->patient_id;
            }

            $user = Auth::guard('api')->user();
            if (!$model->technician_id)
                $model->technician_id = $user->id;

            $model->user_id = $user->id;
        });
    }

    public function getComputeRangeAttribute(){
       if($this->test_value && $this->lab_parameter_id){
          $ranges=LabParameterRange::where('lab_parameter_id',$this->lab_parameter_id)->orderBy('max_value')->get();
          foreach($ranges as $range){
              $expression=null;
            if($range->min_comparator && $range->min_value)
                $expression="$this->test_value $range->min_comparator $range->min_value && ";
            if($range->max_comparator && $range->max_value)
                $expression.="$this->test_value $range->max_comparator $range->max_value";

            

            $expression=rtrim($expression, ' && ');

            $inRange=eval("return $expression;");
            if($inRange)
            return $range;
          }
       }
    }
}

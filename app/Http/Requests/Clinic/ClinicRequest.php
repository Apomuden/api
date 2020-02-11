<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Models\ServiceCategory;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClinicRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $id = $this->route('clinic') ?? null;

        $repository=new RepositoryEloquent(new HospitalService());

        DB::enableQueryLog();
        $consultationService=$repository->findWhere(['name'=> 'Consultation Service'])
                    ->orWhere('name', 'Consultation')->first();


        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('clinics','name',$id),
            'age_group_id'=>'bail|somerimes|nullable|integer|exists:age_groups,id',
            'gender'=>'bail|'.($id?'sometimes':'required').'|set:MALE,FEMALE,BIGENDER',
            'patient_status'=> 'bail|'.($id?'sometimes':'required').'|set:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'main_clinic_id'=> [
                'bail',
                ($id ? 'sometimes' : 'required'),
                'integer',
                 Rule::exists('service_categories','id')->where(function ($query) use($consultationService) {
                    $query->where('hospital_service_id',($consultationService->id??null));
                })
             ],
            'billing_cycle_id'=> 'bail|'. ($id ? 'sometimes' : 'required').'|exists:billing_cycles,id',
            'billing_duration'=>'bail|'. ($id ? 'sometimes' : 'required').'|numeric|min:1',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}

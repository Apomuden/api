<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Repositories\HospitalEloquent;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClinicWithConsultServicesRequest extends ApiFormRequest
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

        $repository=new HospitalEloquent(new HospitalService);
        $hospital_service=$repository->getModel()
        ->where('name', 'Consultation Service')
        ->orWhere('name','consultation')->first();
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('clinics','name',$id),
            'age_group_id'=>'bail|sometimes|nullable|integer|exists:age_groups,id',
            'gender'=>'bail|'.($id?'sometimes':'required').'|set:MALE,FEMALE,BIGENDER',
            'patient_status'=> 'bail|'.($id?'sometimes':'required').'|set:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
            'consultation_services'=>'bail|required|array',
            'consultation_services.*.display_name'=> 'bail|sometimes|nullable|distinct|string|' . $this->softUnique('clinic_consult_services', 'display_name',null),
            'consultation_services.*.billing_cycle_id' => 'bail|required|integer|exists:billing_cycles,id',
            'consultation_services.*.service_category_id' => [
                'bail',
                'required',
                Rule::exists('service_categories','id')->where(function ($query) use($hospital_service){
                     $query->where('hospital_service_id', $hospital_service->id);
                }),
            ],
            'consultation_services.*.duration' => 'bail|required|numeric|min:1',
            'consultation_services.*.price' => 'bail|required|numeric|min:0',
            'consultation_services.*.status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];


    }


}

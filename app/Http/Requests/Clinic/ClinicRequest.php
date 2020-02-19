<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;
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


        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('clinics','name',$id),
            'age_group_id'=>'bail|sometimes|nullable|integer|exists:age_groups,id',
            'gender'=>'bail|'.($id?'sometimes':'required').'|set:MALE,FEMALE,BIGENDER',
            'patient_status'=> 'bail|'.($id?'sometimes':'required').'|set:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'clinic_type_id'=> 'bail|'. ($id ? 'sometimes' : 'required').'|exists:clinic_types,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}

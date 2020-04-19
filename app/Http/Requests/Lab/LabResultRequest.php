<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LabResultRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id=$this->route('result');
        return [
             'investigation_id'=>'bail|'.($id?'sometimes':'required').'|exists:investigations,id|'.$this->softUnique('lab_test_results', 'investigation_id',$id),
             'lab_parameter_id'=>['bail', ($id ? 'sometimes' : 'required'),Rule::exists('lab_service_parameters', 'lab_parameter_id')->where(function($query){
                 $query->join('investigations', 'investigations.service_id','=', 'lab_service_parameters.service_id')
                        ->where('investigations.id',request('investigation_id'));
             }), $this->softUniqueWith('lab_test_results', 'investigation_id,lab_parameter_id', $id)],
             'test_value'=>'bail|'. ($id ? 'sometimes' : 'required'),
             'technician_id'=>['bail','sometimes','nullable',Rule::exists('users','id')->where(function($query){
                   $query->join('roles', 'role.id', '=', 'users.role_id')
                         ->whereIn('roles.name',['Lab Technician', 'Lab Technologist', 'Biomedical Scientist']);
             })],
            'patient_status'=>'bail|string|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
             'status'=>'bail|sometimes|in:ACTIVE,INACTIVE,CANCELLED'
        ];
    }
}

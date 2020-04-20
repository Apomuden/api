<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\Investigation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
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
             'lab_parameter_id'=>['bail', ($id ? 'sometimes' : 'required'), 'exists:lab_parameters,id', $this->softUniqueWith('lab_test_results', 'investigation_id,lab_parameter_id', $id)],
             'test_value'=>'bail|'. ($id ? 'sometimes' : 'required'),
             'technician_id'=>['bail','sometimes','nullable'],
              'patient_status'=>'bail|string|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
             'status'=>'bail|sometimes|in:ACTIVE,INACTIVE,CANCELLED'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            if (isset($all['lab_parameter_id']) && isset($all['investigation_id'])) {
                $lab_parameter=Investigation::find($all['investigation_id'])->service->lab_parameters()->where('lab_parameter_id', $all['lab_parameter_id'])->first();

                if (!$lab_parameter)
                    $validator->errors()->add("lab_parameter_id", "Selected lab_parameter_id is does not belong to the specified investigation's lab service!");
            }

            if(isset($all['technician_id']) && !in_array(User::find($all['technician_id'])->role->name,['Lab Technician', 'Lab Technologist', 'Biomedical Scientist']))
                $validator->errors()->add("technician_id", "Selected technician_id must be a Lab Technician,Lab Technologist or Biomedical Scientist!");
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}

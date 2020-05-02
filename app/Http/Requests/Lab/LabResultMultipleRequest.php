<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\Investigation;
use App\Models\LabTestResult;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LabResultMultipleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $id;
    public function authorize()
    {
        $this->id = $this->route('result');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'investigation_id'=>'bail|'.($this->id?'sometimes':'required').'|exists:investigations,id',
            'results' => 'bail|required|array',
             'results.*.lab_parameter_id'=>['bail', ($this->id ? 'sometimes' : 'required'),'distinct', 'exists:lab_parameters,id'],
            'results.*.test_value'=>'bail|'. ($this->id ? 'sometimes' : 'required'),
            'results.*.test_date' => 'bail|' . ($this->id ? 'sometimes|nullable' : 'required') . '|date',
            'technician_id'=>['bail','sometimes','nullable'],
            'patient_status'=>'bail|string|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'results.*.status'=>'bail|sometimes|in:ACTIVE,INACTIVE,CANCELLED'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            $errorCounter=0;

            foreach($all['results'] as $result){
                $result=(array) $result;
                if (isset($result['lab_parameter_id']) && isset($all['investigation_id'])) {
                    $lab_parameter = Investigation::find($all['investigation_id'])->service->lab_parameters()->where('lab_parameter_id', $result['lab_parameter_id'])->first();

                    if (!$lab_parameter)
                        $validator->errors()->add("lab_parameter_id", "Selected results.{$errorCounter}.lab_parameter_id does not belong to the specified investigation's lab service!");
                }

                if (!$this->id) {
                    $labResult = LabTestResult::where(['investigation_id' => $all['investigation_id'], 'lab_parameter_id' => $result['lab_parameter_id']])->first();

                    if (isset($labResult->test_value) && $labResult->test_value)
                        $validator->errors()->add("test_value", "Test value  for {$labResult->lab_parameter_name} for results.{$errorCounter}.investigation_id: {$labResult->investigation_id} already exists!");
                }

                if (isset($all['technician_id']) && !in_array(User::find($all['technician_id'])->role->name, ['Lab Technician', 'Lab Technologist', 'Biomedical Scientist','Dev']))
                    $validator->errors()->add("technician_id", "Selected results.{$errorCounter}.technician_id must be a Lab Technician,Lab Technologist or Biomedical Scientist!");

                $errorCounter++;
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}

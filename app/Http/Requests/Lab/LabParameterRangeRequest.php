<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\LabParameter;

class LabParameterRangeRequest extends ApiFormRequest
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
        $id=$this->route('range');
        return [
            'lab_parameter_id'=> 'bail|'.($id?'sometimes':'required').'|integer|exists:lab_parameters,id',
            'flag'=>'bail|sometimes|nullable|string',
            'min_comparator'=> 'bail|'. ($id ? 'sometimes' : 'required').'|in:>,>=,<,<=,=',
            'min_value'=>'bail|numeric',
            'max_comparator'=> 'bail|'. ($id ? 'sometimes' : 'required').'|in:>,>=,<,<=,=',
            'max_value'=>'bail|numeric',

            'min_age' => 'bail|sometimes|nullable|integer|numeric|min:0',
            'min_age_unit' => 'bail|sometimes|nullable|string|in:DAY,WEEK,MONTH,YEAR',

            'max_age' => 'bail|sometimes|nullable|integer|numeric|min:0',
            'max_age_unit' => 'bail|sometimes|nullable|string|in:DAY,WEEK,MONTH,YEAR',
            
            'gender'=>'bail|'. ($id ? 'sometimes' : 'required').'|set:MALE,FEMALE',
            'status'=>'bail|string|in:ACTIVE,INACTIVE'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            if (isset($all['lab_parameter_id'])) {
                $lab_parameter = LabParameter::where('id',$all['lab_parameter_id'])->where('value_type','Number')->first() ?? null;

                if (!$lab_parameter)
                    $validator->errors()->add("lab_parameter_id", "Selected lab_parameter_id is does not have a numeric value type!");
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}

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
            'lab_parameter_id'=> 'bail|'.($id?'sometimes':'required').'|integer|exists:lab_parameters,id|'.$this->softUniqueWith('lab_parameter_ranges', 'flag,lab_parameter_id,min_age,min_age_unit,max_age,max_age_unit,gender',$id),
            'flag'=>'bail|sometimes|nullable|string',
            'min_comparator'=> 'bail|sometimes|nullable|in:>,>=,<,<=,=',
            'min_value'=> 'bail|sometimes|nullable|numeric',
            'max_comparator'=> 'bail|sometimes|nullable|in:>,>=,<,<=,=',
            'max_value'=> 'bail|sometimes|nullable|numeric',

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

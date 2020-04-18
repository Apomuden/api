<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class LabTestSampleRequest extends ApiFormRequest
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
        $id=$this->route('sample');
        return [
            'sample_code'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('lab_test_samples','sample_code',$id),
            'investigation_id'=>'bail|'. ($id ? 'sometimes' : 'required').'|exists:investigations,id',
            'lab_sample_type_id'=> 'bail|'. ($id ? 'sometimes' : 'required').'|exists:lab_sample_types,id',

            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}

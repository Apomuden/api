<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\Investigation;
use App\Models\Service;
use App\Models\User;
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
            'sample_code'=>'bail|'.($id?'sometimes':'required'),
            'investigation_id'=>'bail|'. ($id ? 'sometimes' : 'required').'|exists:investigations,id',
            'lab_sample_type_id'=> 'bail|'. ($id ? 'sometimes' : 'required').'|exists:lab_sample_types,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            if($all['investigation_id'] && $all['lab_sample_type_id']){
                $sample_type = Investigation::find($all['investigation_id'])->service->lab_sample_types()->where('lab_sample_type_id', $all['lab_sample_type_id'])->first();

                if (!$sample_type)
                    $validator->errors()->add("lab_sample_type_id", "Selected lab_sample_type_id does not belong to the specified investigation service!");
            }

            if (isset($all['technician_id']) && !in_array(User::find($all['technician_id'])->role->name, ['Lab Technician', 'Lab Technologist', 'Biomedical Scientist']))
                $validator->errors()->add("technician_id", "Selected technician_id must be a Lab Technician,Lab Technologist or Biomedical Scientist!");

        });
    }
    public function all($keys = null)
    {
        return parent::all($keys);

    }
}

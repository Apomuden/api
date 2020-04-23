<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\Investigation;
use App\Models\LabTestSample;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LabTestSampleMultipleRequest extends ApiFormRequest
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
        $id=null;
        return [
            'tests'=>'bail|array',
            'tests.*.samples'=>'bail|array',
            'tests.*.samples.*.sample_code'=>'bail|'.($id?'sometimes':'required'),
            'tests.*.investigation_id'=>'bail|distinct|'. ($id ? 'sometimes' : 'required').'|exists:investigations,id',
            'tests.*.samples.*.lab_sample_type_id'=> 'bail|distinct|'. ($id ? 'sometimes' : 'required').'|exists:lab_sample_types,id',
            'tests.*.samples.*.status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            $testCounter=0;
            foreach($all['tests'] as $test){
                $test=(array) $test;
                $samples=(array)$test['samples'];
                $sampleCounter=0;
                foreach($samples as $sample){
                    if ($test['investigation_id'] && $sample['lab_sample_type_id']) {
                        $sample_type = Investigation::find($test['investigation_id'])->service->lab_sample_types()->where('lab_sample_type_id', $sample['lab_sample_type_id'])->first();

                        if (!$sample_type)
                            $validator->errors()->add("lab_sample_type_id", "Selected tests.{$testCounter}.{$sampleCounter}.lab_sample_type_id does not belong to the specified investigation service!");

                        $LabTestSample=LabTestSample::where(['lab_sample_type_id'=>$sample['lab_sample_type_id'], 'investigation_id'=> $test['investigation_id']])->first();

                         if($LabTestSample)
                            $validator->errors()->add("lab_sample_type_id", "Selected tests.{$testCounter}.{$sampleCounter}.lab_sample_type_id is already assigned to investigation request!");
                    }

                    $sampleCounter++;
                }
                if (isset($all['technician_id']) && !in_array(User::find($all['technician_id'])->role->name, ['Lab Technician', 'Lab Technologist', 'Biomedical Scientist']))
                    $validator->errors()->add("technician_id", "Selected technician_id must be a Lab Technician,Lab Technologist or Biomedical Scientist!");
                $testCounter++;
            }
        });
    }
    public function all($keys = null)
    {
        return parent::all($keys);

    }
}

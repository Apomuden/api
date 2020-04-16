<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LabServiceParameterRequest extends ApiFormRequest
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
        return [
            'parameters'=>'bail|array',
            'parameters.*' => 'bail|required|distinct|exists:lab_parameters,id'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //$all = $this->all();
            $investigation_service = Service::find(request('service_id'))->hospital_service ?? null;
            if(!in_array(ucwords($investigation_service->name),['Investigation', 'Investigations']))
                $validator->errors()->add("service_id", "Selected service_id is not a valid investigation service!");
        });
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);

        $all=[];
        
        foreach($data['parameters'] as $parameter)
          $all[$parameter]=['created_at'=>now(),'updated_at'=>now()];

        $data['parameters']=$all;

        return $data;
    }
}

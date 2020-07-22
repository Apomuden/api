<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LabServiceSampleTypeRequest extends ApiFormRequest
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
            'sample_types' => 'bail|array',
            'sample_types.*.id' => 'bail|required|distinct|exists:lab_sample_types,id',
            'sample_types.*.order' => 'bail|required|distinct|integer|numeric|min:1'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //$all = $this->all();
            $investigation_service = Service::find(request('service_id'))->hospital_service ?? null;
            if (!in_array(ucwords($investigation_service->name ?? null), ['Investigation', 'Investigations'])) {
                $validator->errors()->add("service_id", "Selected service_id is not a valid investigation service!");
            }
        });
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);

        $all = [];

        foreach ($data['sample_types'] as $parameter) {
            if (Request::isMethod('post')) {
                $all[$parameter['id']] = ['order' => $parameter['order'], 'created_at' => now(), 'updated_at' => now()];
            } else {
                $all[$parameter['id']] = $parameter['id'];
            }
        }
           $data['sample_types'] = $all;

        return $data;
    }
}

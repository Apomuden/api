<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use App\Models\ClinicService;

/**
 * @property array components
 */
class ConsultationServiceComponentsRequest extends ApiFormRequest
{

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
            'components' => 'bail|required|array',
            'components.*.id' => ['bail', 'required', 'distinct', 'exists:consultation_components,id'
            ]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clinic = ClinicService::find(request('service_id'));

            if (is_null($clinic))
                $validator->errors()->add("Service id", "The id in path is not valid");
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        $all = [];

        foreach ($data['components'] as $component) {
            $all[$component['id']] = [];
        }
        $data['components'] = $all;

        return $data;
    }
}

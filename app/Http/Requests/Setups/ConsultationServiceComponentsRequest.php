<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use App\Models\ClinicService;
use App\Models\ConsultationQuestionResponse;
use App\Models\HospitalService;
use App\Models\Service;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'components.*.id' => ['bail', 'required', 'distinct', 'exists:consultation_components,id'],
            'components.*.order' => 'bail|required|distinct|integer|min:1'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clinic = Service::find(request('service_id'));

            if (is_null($clinic))
                $validator->errors()->add("Service id", "The id in path is not a Consultation service!");
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        $all = [];

        foreach ($data['components'] as $component) {
            if ($this->method() == self::METHOD_DELETE)
                $all[$component['id']] = $component['id'];
            else
                $all[$component['id']] = ['order' => $component['order']];
        }
        $data['components'] = $all;

        return $data;
    }
}

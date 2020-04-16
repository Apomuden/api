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
        $investigation_service =HospitalService::where('name', 'Investigation')
            ->orWhere('name', 'Investigations')->where()->first();
        return [
            'service_id' => ['bail','required',Rule::exists('services','id')->where(function($query) use($investigation_service){
                $query->where('hospital_service_id', $investigation_service->id);
            })],
            'lab_parameter_id' => 'bail|required|string|exists:lab_parameters,id'
        ];
    }
}

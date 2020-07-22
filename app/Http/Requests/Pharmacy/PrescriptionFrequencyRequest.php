<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class PrescriptionFrequencyRequest extends ApiFormRequest
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
        $id = $this->route('prescriptionfrequency') ?? null; //TODO: Change the route param from dummyparam

        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('prescription_frequencies', 'name', $id),
            'value' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}

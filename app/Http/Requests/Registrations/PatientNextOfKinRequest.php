<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Repositories\HospitalEloquent;

class PatientNextOfKinRequest extends ApiFormRequest
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

        $id = $this->route('patientnextofkin') ?? null;
        return [
             'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
             'phone' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:9',
             'relation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:relationships,id',
             'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id|' . $this->softUniqueWith('patient_next_of_kin', 'name,phone,patient_id', $id),
             'address' => 'bail|sometimes|nullable',
             'status' => 'bail|sometimes|in:ACTIVE,INACTIVE,NULLIFIED,OLD'
        ];
    }
}

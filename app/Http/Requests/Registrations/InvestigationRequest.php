<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Models\Role;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Illuminate\Validation\Rule;

class InvestigationRequest extends ApiFormRequest
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
        $id = $this->route('investigation') ?? null;

        $repository = new RepositoryEloquent(new HospitalService);

        $investigation_service = $repository
            ->findWhere(['name' => 'Investigation'])
            ->orWhere('name', 'Investigations')->first();

        $repository = new RepositoryEloquent(new Role);
        $role = $repository->findWhere(['name' => 'Doctor'])->orWhere('name', 'doctor')
            ->orWhere('name', 'DOCTOR')->first();

      /*   $sponsorship_type = (request()->input('sponsorship_type')) ?? null;

        if($sponsorship_type)
            $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
        else {
            $sponsorship_type_id = (request()->input('sponsorship_type_id')) ?? null;
            if ($sponsorship_type_id) {
                $repository = new RepositoryEloquent(new SponsorshipType);
                $sponsorship_type = $repository->find($sponsorship_type_id)->name ?? null;
                $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
            }
        } */

        return [
            "consultation_id" => 'bail|integer|' . ($id|| request('patient_status') == 'WALK-IN' ? 'sometimes' : 'required').'|exists:consultations,id',
            'patient_id' => 'bail|' . ($id || request('patient_status') != 'WALK-IN' ? 'sometimes' : 'required') . '|exists:patients,id',

            'funding_type_id' => 'bail|sometimes|nullable|exists:funding_types,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'consultation_date' => 'bail|sometimes|date',
            'cancelled_date' => 'bail|sometimes|date',
            'order_type'=>'bail|'. ($id ? 'sometimes' : 'required').'|in:INTERNAL,EXTERNAL',
            'funding_type_id' => 'bail|sometimes|integer|exists:funding_types,id',
            'user_id' => 'bail|sometimes|nullable|integer|exists:users, id',
            'age' => 'bail|sometimes|integer|min:0',

            'billing_sponsor_id' => 'bail|sometimes|nullable|exists:billing_sponsors,id',

            'service_id' => [
                'bail', ($id ? 'sometimes' : 'required'), 'integer',
                Rule::exists('services', 'id')->where(function ($query) use ($investigation_service) {
                    $query->where(['hospital_service_id' => $investigation_service->id]);
                })
            ],
            'consultant_id' => [
                'bail', 'sometimes', 'nullable',
                Rule::exists('users', 'id')->where(function ($query) use ($role) {
                    $query->where(['role_id' => $role->id ?? null]);
                })
            ],
            'canceller_id' => [
                'bail', 'sometimes', 'nullable',
                'exists:users,id'
            ]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            if (isset($all['billing_sponsor_id'])) {
                $patient_sponsor = $this->consultation->patient->patient_sponsors()->active()->where('billing_sponsor_id', $all['billing_sponsor_id'])->first() ?? null;

                if (!$patient_sponsor)
                    $validator->errors()->add("billing_sponsor_id", "Selected billing_sponsor_id is not a valid sponsor of the patient!");
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}

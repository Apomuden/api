<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Consultation;
use App\Models\HospitalService;
use App\Models\Role;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Illuminate\Validation\Rule;

class InvestigationMultipleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $consultation;
    public function authorize()
    {
        $this->consultation= Consultation::find(request('consultation_id'));
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

        $role = $repository->findWhere(['name' => 'Doctor'])
            ->orWhere('name', 'DEV')->first();


        return [
            "consultation_id" => 'bail|' . ($id||request('patient_status')== 'WALK-IN' ? 'sometimes' : 'required').'|exists:consultations,id',
            'patient_id' => 'bail|'.($id || request('patient_status') != 'WALK-IN'?'sometimes':'required').'|exists:patients,id',
            'funding_type_id' => 'bail|sometimes|nullable|exists:funding_types,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'consultation_date' => 'bail|sometimes|date',
            'investigations' => 'bail|required|array',
            'investigations.*.cancelled_date' => 'bail|sometimes|date',
            'investigations.*.order_type'=> 'bail|'. ($id ? 'sometimes' : 'required').'|in:INTERNAL,EXTERNAL',
            'investigations.*.funding_type_id' => 'bail|sometimes|integer|exists:funding_types,id',
            'user_id' => 'bail|sometimes|nullable|integer|exists:users, id',
            'age' => 'bail|sometimes|integer|min:0',

            'investigations.*.billing_sponsor_id' => 'bail|'.($id||request('patient_status') != 'WALK-IN'? 'sometimes|nullable':'required').'|exists:billing_sponsors,id',

            'investigations.*.service_id' => [
                'bail', ($id ? 'sometimes' : 'required'), 'integer',
                'distinct',
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
            'investigations.*.canceller_id' => [
                'bail', 'sometimes', 'nullable',
                'exists:users,id'
            ]
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();
            $errorCounter = 0;

            foreach ($all['investigations'] as $investigation) {

                $investigation=(array)$investigation;

                if(isset($investigation['billing_sponsor_id'])){
                    $patient_sponsor = $this->consultation->patient->patient_sponsors()->active()->where('billing_sponsor_id', $investigation['billing_sponsor_id'])->first()??null;

                    if (!$patient_sponsor)
                        $validator->errors()->add("billing_sponsor_id", "Selected Investigations.$errorCounter.billing_sponsor_id is not a valid sponsor of the patient!");

                    $errorCounter++;
                }
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }

}

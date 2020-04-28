<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Consultation;
use App\Models\HospitalService;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Illuminate\Validation\Rule;

class ProcedureMultipleRequest extends ApiFormRequest
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
        $id = $this->route('procedure') ?? null;

        $repository = new RepositoryEloquent(new HospitalService);

        $procedure_service = $repository
            ->findWhere(['name' => 'Procedure'])
            ->orWhere('name', 'Surgery')->first();

        $repository = new RepositoryEloquent(new Role);

        $role = $repository->findWhere(['name' => 'Doctor'])
            ->orWhere('name', 'DEV')->first();


        return [
            "consultation_id" => 'bail|integer|' . ($id ? 'sometimes' : 'required').'|exists:consultations,id',
            'funding_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:funding_types,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT',
            'consultation_date' => 'bail|sometimes|date',
            'procedures' => 'bail|required|array',
            'procedures.*.cancelled_date' => 'bail|sometimes|date',
            'procedures.*.order_type'=> 'bail|'. ($id ? 'sometimes' : 'required').'|in:INTERNAL,EXTERNAL',
            'procedures.*.funding_type_id' => 'bail|sometimes|integer|exists:funding_types,id',
            'user_id' => 'bail|sometimes|nullable|integer|exists:users, id',
            'age' => 'bail|sometimes|integer|min:0',

            'procedures.*.billing_sponsor_id' => 'bail|sometimes|integer|exists:billing_sponsors,id',

            'procedures.*.service_id' => [
                'bail', ($id ? 'sometimes' : 'required'), 'integer',
                'distinct',
                Rule::exists('services', 'id')->where(function ($query) use ($procedure_service) {
                    $query->where(['hospital_service_id' => $procedure_service->id]);
                })
            ],
            'consultant_id' => [
                'bail', 'sometimes', 'nullable',
                Rule::exists('users', 'id')->where(function ($query) use ($role) {
                    $query->where(['role_id' => $role->id ?? null]);
                })
            ],
            'procedures.*.canceller_id' => [
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

            foreach ($all['procedures'] as $procedure) {

                $procedure=(array)$procedure;

                if(isset($procedure['billing_sponsor_id'])){
                    $patient_sponsor = $this->consultation->patient->patient_sponsors()->active()->where('billing_sponsor_id', $procedure['billing_sponsor_id'])->first()??null;

                    if (!$patient_sponsor)
                        $validator->errors()->add("billing_sponsor_id", "Selected procedures.$errorCounter.billing_sponsor_id is a valid sponsor of the patient!");

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

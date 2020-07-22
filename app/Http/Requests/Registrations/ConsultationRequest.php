<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\AgeClassification;
use App\Models\Consultation;
use App\Models\HospitalService;
use App\Models\Patient;
use App\Models\Role;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ConsultationRequest extends ApiFormRequest
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
        $id = ($this->route('consultation') ?? $this->route('consultationservicerequest')) ?? null;

        $patient_id = request('patient_id') ?? null;
        $patient = null;

        $status = request('status') ?? null;

        if ($patient_id) {
            $patient = (new RepositoryEloquent(new Patient()))->find($patient_id);
        } elseif ($id) {
            $patient = (new RepositoryEloquent(new Consultation()))->find($id)->patient;
        }

        $sponsorship_type = (request()->input('sponsorship_type')) ?? null;
        $clinic_id = (request()->input('clinic_id')) ?? null;
        if ($sponsorship_type) {
            $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
        } else {
            $sponsorship_type_id = (request()->input('sponsorship_type_id')) ?? null;
            if ($sponsorship_type_id) {
                $repository = new RepositoryEloquent(new SponsorshipType());
                $sponsorship_type = $repository->find($sponsorship_type_id)->name ?? null;
                $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
            }
        }
        $repository = new RepositoryEloquent(new HospitalService());
        $consultation_service = $repository
            ->findWhere(['name' => 'Consultation'])
            ->orWhere('name', 'Consultation service')->first();
        $repository = new RepositoryEloquent(new Role());
        $role = $repository->findWhere(['name' => 'Doctor'])
            ->orWhere('name', 'DEV')->first();

        return [
            'consultation_given' => 'bail|sometimes|nullable|string',
            'order_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|in:INTERNAL,EXTERNAL',
            'service_quantity' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:1',
            'service_fee' => 'bail|' . ($id ? 'sometimes' : 'required_unless:order_type,EXTERNAL') . '|numeric',
            'age' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|min:0',
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'user_id' => 'bail|sometimes|nullable|integer|exists:users, id',
            'clinic_id' => ['bail', ($id ? 'sometimes' : 'required'), 'integer','exists:clinics,id'],
            'consultation_service_id' => [
                'bail', ($id ? 'sometimes' : 'required'), 'integer',
                Rule::exists('clinic_services', 'service_id')->where(function ($query) use ($clinic_id, $consultation_service) {
                    $query->where(['hospital_service_id' => $consultation_service->id ?? null, 'clinic_id' => $clinic_id]);
                })
            ],
            'consultant_id' => [
                'bail', 'sometimes', 'nullable',
                Rule::exists('users', 'id')->where(function ($query) use ($role) {
                    $query->where(['role_id' => $role->id ?? null]);
                })
            ],
            'funding_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:funding_types,id',
            'sponsorship_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'sponsorship_type_id' => 'bail|sometimes|nullable|integer|exists:sponsorship_types,id',
            'age_group_id' => 'bail|sometimes|nullable|integer|exists:age_groups,id',
            'attendance_date' => 'bail|sometimes|nullable|date',
            'billing_sponsor_id' => 'bail|' . ($id || ($sponsorship_type == 'patient' || $sponsorship_type == 'government insurance') ? 'sometimes|nullable' : 'required') . '|integer|exists:billing_sponsors,id',
            'patient_sponsor_id' => 'bail|' . ($id || ($sponsorship_type == 'patient' || $sponsorship_type == 'government insurance') ? 'sometimes|nullable' : 'required') . '|integer|exists:patient_sponsors,id',
            'member_id' => 'bail|sometimes|nullable|string|exists:patient_sponsors,member_id',
            'staff_id' => 'bail|sometimes|nullable|string|exists:patient_sponsors,staff_id',
            'card_serial_no' => 'bail|' . (!$id && $sponsorship_type == 'government insurance' ? 'required' : 'sometimes|nullable') . '|string|exists:patient_sponsors,card_serial_no',
            'ccc' => 'bail|' . (!$id && $sponsorship_type == 'government insurance' ? 'required' : 'sometimes|nullable') . '|string|size:5|unique:consultations,ccc,' . $id,
            'started_at' => 'bail|sometimes|nullable|date',
            'ended_at' => 'bail|sometimes|nullable|date',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
            'status' => 'bail|sometimes|string|in:COMPLETED,IN-QUEUE,SUSPENDED,DISCHARGE,FINISH',
            'pregnant' => ['bail',' boolean',Rule::requiredIf(function () use ($patient, $id) {
                return !$id && $patient && $patient->gender == 'FEMALE' && $patient->age >= 13;
            })],
            'illness_type_id' => ['bail','integer','sometimes',Rule::exists('illness_types', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'consulting_room_id' => ['bail', 'integer', 'sometimes', Rule::exists('consulting_rooms', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'discharge_reason_id' => ['bail', 'integer', Rule::requiredIf(function () use ($status) {
                return $status == 'DISCHARGE';
            }), Rule::exists('discharge_reasons', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'review_date' => ['bail', Rule::requiredIf(function () use ($status) {
                return $status == 'DISCHARGE';
            }),'date']
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();
            if (isset($all['dob']) && Carbon::parse($all['dob']) > now()) {
                $validator->errors()->add('dob', 'dob cannot be greater than today!');
            } else {
                $repository = new RepositoryEloquent(new AgeClassification());
                $age_class = $repository->findWhere(['name' => 'GHS STATEMENT OF OUTPATIENT'])->orWhere('name', 'GHS REPORTS')->first();
                if (!$age_class) {
                    $validator->errors()->add('dob', "An age class with name 'GHS STATEMENT OF OUTPATIENT' or 'GHS REPORTS' must be setup!");
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

<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Patient;
use App\Repositories\RepositoryEloquent;

class ConsultationRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $id = $this->route('consultation') ?? $this->route('consultationservicerequest') ?? null;
        return [
            'consultation_given'=>'bail|sometimes|nullable|string',
            'order_type'=>'bail|'.($id?'sometimes':'required').'|string|in:INTERNAL,EXTERNAL',
            'service_quantity'=>'bail|'.($id?'sometimes':'required').'|numeric|min:1',
            'service_fee'=>'bail|'.($id?'sometimes':'required_unless:order_type,EXTERNAL').'|numeric',
            'age'=>'bail|'.($id?'sometimes':'required').'|integer|min:1',
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients, id',
            'user_id'=>'bail|sometimes|nullable|integer|exists:users, id',
            'consultation_service_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:clinic_consult_services, id',
            'funding_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:funding_types, id',
            'sponsorship_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:sponsorship_types, id',
            'age_group_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:age_groups, id',
            'attendance_date'=>'bail|'.($id?'sometimes':'required').'|date',
            'started_at'=>'bail|sometimes|nullable|date',
            'ended_at'=>'bail|sometimes|nullable|date',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
            'status'=>'bail|sometimes|string|in:ACTIVE,INACTIVE',
        ];
    }
}

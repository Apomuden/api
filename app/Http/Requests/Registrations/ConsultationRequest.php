<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Patient;
use App\Models\SponsorshipType;
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
        $id = ($this->route('consultation') ?? $this->route('consultationservicerequest')) ?? null;
        $sponsorship_type = (request()->input('sponsorship_type'))??null;
        if ($sponsorship_type) {
            $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
        }
        else {
            $sponsorship_type_id = (request()->input('sponsorship_type_id')) ?? null;
            if ($sponsorship_type_id) {
                $repository = new RepositoryEloquent(new SponsorshipType);
                $sponsorship_type = $repository->find($sponsorship_type_id)->name??null;
                $sponsorship_type = $sponsorship_type?strtolower($sponsorship_type):null;
            }
        }
        return [
            'consultation_given'=>'bail|sometimes|nullable|string',
            'order_type'=>'bail|'.($id?'sometimes':'required').'|string|in:INTERNAL,EXTERNAL',
            'service_quantity'=>'bail|'.($id?'sometimes':'required').'|numeric|min:1',
            'service_fee'=>'bail|'.($id?'sometimes':'required_unless:order_type,EXTERNAL').'|numeric',
            'age'=>'bail|'.($id?'sometimes':'required').'|integer|min:1',
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id',
            'user_id'=>'bail|sometimes|nullable|integer|exists:users, id',
            'consultation_service_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:clinic_consult_services,id',
            'funding_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:funding_types,id',
            'sponsorship_type'=>'bail|'.($id?'sometimes':'required').'|string',
            'sponsorship_type_id'=>'bail|sometimes|nullable|integer|exists:sponsorship_types,id',
            'age_group_id'=>'bail|sometimes|nullable|integer|exists:age_groups,id',
            'attendance_date'=>'bail|'.($id?'sometimes':'required').'|date',
            'billing_sponsor_id'=>'bail|'.($id && ($sponsorship_type==='patient' || $sponsorship_type==='government insurance') ?'sometimes|nullable':'required').'|integer|exists:billing_sponsors,id',
            'member_id'=>'bail|sometimes|nullable|integer|exists:patient_sponsors,member_id',
            'staff_id'=>'bail|sometimes|nullable|integer|exists:patient_sponsor,staff_id',
            'card_serial_no'=>'bail|'.(!$id && $sponsorship_type==='government insurance' ? 'required':'sometimes|nullable').'|integer|exists:patient_sponsor,card_serial_no',
            'ccc'=>'bail|'.($id && $sponsorship_type!=='government insurance' ? 'sometimes|nullable':'required').'|string|size:5|unique:consultations,ccc',
            'started_at'=>'bail|sometimes|nullable|date',
            'ended_at'=>'bail|sometimes|nullable|date',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
            'status'=>'bail|sometimes|string|in:COMPLETED,IN-QUEUE,SUSPENDED',
        ];
    }
}

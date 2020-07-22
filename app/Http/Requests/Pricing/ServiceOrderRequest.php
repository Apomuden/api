<?php

namespace App\Http\Requests\Pricing;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class ServiceOrderRequest extends ApiFormRequest
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
        $id = $this->route('serviceorder') ?? null;
        return [
            'patient_id' => ['bail', ($id ? 'sometimes' : 'required'),'integer',Rule::exists('patients', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'clinic_id' => ['bail', ($id ? 'sometimes' : 'required'),'integer',Rule::exists('clinics', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'age' => 'bail|sometimes|integer',
            'gender' => 'bail|sometimes|in:MALE,FEMALE',
            'patient_status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'service_id' => ['bail', ($id ? 'sometimes' : 'required'),Rule::exists('services', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'service_fee' => 'bail|numeric|' . ($id ? 'sometimes' : 'required'),
            'service_quantity' => 'bail|integer|min:1|' . ($id ? 'sometimes' : 'required'),
            //'service_total_amt' => 'bail|numeric|min:1|' . ($id ? 'sometimes' : 'required'),
            'service_date' => 'bail|' . ($id ? 'sometimes' : 'required') . '|date',
            'order_type' => 'bail|string|in:INTERNAL,EXTERNAL',
            'orderer_id' => ['bail', 'sometimes',Rule::exists('users', 'id')->where(function ($query) {
                $query->where('status', 'ACTIVE');
            })],
            'prepaid' => 'bail|sometimes|boolean',
            'paid_service_price' => 'bail|sometimes|numeric',
            'paid_service_quantity' => 'bail|sometimes|integer',
            //'paid_service_total_amt'=>'bail|sometimes|numeric',
            'funding_type_id' => 'bail|sometimes|exists:funding_types,id',
            'billing_system_id' => 'bail|sometimes|exists:billing_systems,id',
            'billing_cycle_id' => 'bail|sometimes|exists:billing_cycles,id',
            'payment_style_id' => 'bail|sometimes|exists:payment_styles,id',
            'payment_channel_id' => 'bail|sometimes|exists:payment_channel,id',
            'insured' => 'bail|sometimes|boolean',
            'billing_sponsor_id' => 'bail|sometimes|exists:billing_sponsors,id',
            'sponsorship_policy_id' => 'bail|sometimes|exists:sponsorship_policies,id',
            'cancelled_date' => 'bail|sometime|nullable|date',
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:PENDING,PART-PAYMENT,FULL-PAYMENT,CANCELLED,ABSCOND,REFUNDED'
        ];
    }
}

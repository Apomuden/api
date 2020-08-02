<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\ApiFormRequest;
use App\Models\PaymentChannel;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Illuminate\Validation\Rule;

class DepositRequest extends ApiFormRequest
{
    private $payment_channel = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (request('payment_channel_id'))
        $this->payment_channel = PaymentChannel::find(request('payment_channel_id'));
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('deposit') ?? null;
        $sponsorship_type_id = (request()->input('sponsorship_type_id')) ?? null;
        $sponsorship_type = null;
        if ($sponsorship_type_id) {
            $repository = new RepositoryEloquent(new SponsorshipType());
            $sponsorship_type = $repository->find($sponsorship_type_id)->name ?? null;
            $sponsorship_type = $sponsorship_type ? strtolower($sponsorship_type) : null;
        }
        return [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|'.$this->softExists('patients','id'),
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'funding_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|'.$this->softExists('funding_types','id'),
            'sponsorship_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|'.$this->softExists('sponsorship_types','id'),
            'billing_sponsor_id' => 'bail|' . ($id || ($sponsorship_type == 'patient' || $sponsorship_type == 'government insurance') ? 'sometimes|nullable' : 'required') . '|integer|'.$this->softExists('billing_sponsors', 'id'),
            'patient_sponsor_id' => 'bail|' . ($id || ($sponsorship_type == 'patient' || $sponsorship_type == 'government insurance') ? 'sometimes|nullable' : 'required') . '|integer|'.$this->softExists('patient_sponsors','id'),
            'payment_channel_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|'.$this->softExists('payment_channels','id'),
            'deposit_amount' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:1',
            'bank_id' => ['bail', Rule::requiredIf(function () use ($id) {
                return !$id && isset($this->payment_channel) && in_array(ucwords($this->payment_channel->name), ['Bank Interface', 'Banking Interface', 'Bank Deposit','Cheque']);
            }), Rule::exists('banks', 'id')->where('priority', 0)->whereNull('deleted_at')],
            'cheque_no' => ['bail', Rule::requiredIf(function () use($id) {
                return !$id && isset($this->payment_channel) && ucwords($this->payment_channel->name) == 'Cheque';
            }), $this->softUnique('ereceipts', 'cheque_no', $id)],
            'payee_transaction_id' => ['bail', Rule::requiredIf(function () use ($id) {
                return !$id && isset($this->payment_channel) && in_array(ucwords($this->payment_channel->name), ['MTN Mobile Money', 'AirtelTigo Money', 'Vodafone Cash', 'G-Money', 'Bank Interface', 'Banking Interface', 'Bank Deposit']);
            }), $this->softUnique('ereceipts', 'payee_transaction_id', $id)],
            'payee_account_no' => ['bail', Rule::requiredIf(function () use ($id) {
                return !$id && trim(request('cheque_no')) && request('cheque_no') != null || isset($this->payment_channel) && in_array(ucwords($this->payment_channel->name), ['MTN Mobile Money', 'Cheque', 'CHEQUE', 'AirtelTigo Money', 'Vodafone Cash', 'G-Money']);
            })],
            'reason' => 'bail|sometimes|nullable|string',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}

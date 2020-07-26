<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\ApiFormRequest;
use App\Models\PaymentChannel;
use Illuminate\Validation\Rule;

class EreceiptRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $payment_channel=null;
    public function authorize()
    {
        if(request('payment_channel_id'))
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
        $id=$this->route('ereceipt')??null;
        return [
            'payment_channel_id'=>['bail',Rule::requiredIf(function(){
                return request('cheque_no') || request('bank_id') || request('payee_transaction_id');
            })],
            'cheque_no' => ['bail',Rule::requiredIf(function(){
                return isset($this->payment_channel) && ucwords($this->payment_channel->name)=='Cheque';
            }),$this->softUnique('ereceipts', 'cheque_no', $id)],
            'bank_id'=>['bail',Rule::requiredIf(function() use($id){
                return $id && trim(request('cheque_no')) && request('cheque_no') != null;
            }),$this->softExists('banks','id')],
            'payee_transaction_id'=>['bail',Rule::requiredIf(function() use($id){
                return $id && isset($this->payment_channel) && in_array($this->payment_channel->name, ['MTN Mobile Money', 'AirtelTigo Money', 'Vodafone Cash', 'G-Money']);
            }),$this->softUnique('ereceipts', 'payee_transaction_id', $id)],
            'payee_account_no'=>['bail',Rule::requiredIf(function() use($id){
                return $id && trim(request('cheque_no')) && request('cheque_no')!=null|| isset($this->payment_channel) && in_array($this->payment_channel->name,['MTN Mobile Money', 'Cheque','CHEQUE', 'AirtelTigo Money', 'Vodafone Cash', 'G-Money']);
            })],

        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $all = $this->all();

            if(!(isset($all['bank_id']) && $all['bank_id'])  && isset($this->payment_channel->name) && in_array(ucwords($this->payment_channel->name), ['Bank Interface', 'Banking Interface', 'Bank Deposit']))
            $validator->errors()->add('bank_id', 'bank id is required!');

            else if((isset($all['cheque_no']) && $all['cheque_no'])){
                if (isset($this->payment_channel->name) && ucwords($this->payment_channel->name) != 'Bank Deposit')
                    $validator->errors()->add('cheque_no', 'cheque no can only be passed for a bank deposit payment channel');
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        return $data;
    }
}

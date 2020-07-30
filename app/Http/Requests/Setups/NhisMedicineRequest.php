<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class NhisMedicineRequest extends ApiFormRequest
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
        $id=$this->route('nhismedicine')??null;
        return [
            'code'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('nhis_medicines','code',$id),
            'name'=>'bail|'. ($id ? 'sometimes' : 'required').'|'. $this->softUnique('nhis_medicines', 'name', $id),
            'pricing_unit'=> 'bail|' . ($id ? 'sometimes' : 'required'),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}

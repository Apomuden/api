<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceRequest extends ApiFormRequest
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
        $id=$this->route('attendance')??null;

       $insured=request()->input('insured')??'YES';

        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|exists:patients,id',
            //'patient_status'=> 'bail|' . ($id ? 'sometimes' : 'required'). '|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'insured'=>'bail|sometimes|nullable|in:YES,NO',
            'sponsor_id'=> ['bail',$insured=='YES'?'required':'sometime', $insured == 'YES' ? 'required' : 'nullable',
               Rule::exists('billing_sponsors','id')->where(function($query){
                   $query->where('status','ACTIVE');
               })
            ],
            'clinic_id'=> [
                'bail', ($id ? 'sometimes' : 'required'),
                 Rule::exists('clinics', 'id')->where(function ($query) {
                    $query->where('status', 'ACTIVE');
                })
            ],
            'attendance_date'=>'bail|sometimes|nullable|date'
        ];
    }
}

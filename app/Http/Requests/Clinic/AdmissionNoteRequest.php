<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdmissionNoteRequest extends ApiFormRequest
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
        $id=$this->route('admissionnote');

        $repository = new RepositoryEloquent(new Role);

        $roles = $repository->findWhere(['name' => 'Nurse'])
            ->orWhere('name', 'DEV')->get();

        $roleIds = [];
        foreach ($roles as $role) {
            $roleIds[] = $role->id;
        }

        return [
            'consultation_id'=>['bail', Rule::requiredIf(function () use ($id) {
                return (!$id && !request('patient_id'));
            }),'exists:consultations,id'],
            'patient_id'=>['bail',Rule::requiredIf(function() use($id){
                return (!$id && !request('consultation_id'));
            }),'exists:patients,id'],
            'patient_status'=>'bail|'.($id?'sometimes':'required').'|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'consultant_id'=>['bail', ($id ? 'sometimes' : 'required'),Rule::exists('users','id')->where(function($query) use($roleIds){
                $query->whereIn('role_id', $roleIds);
            })],
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE,CANCELLED',
            //'delivery_date'. ($id ? 'sometimes' : 'required').'|date',
            'notes'=>'bail|'. ($id ? 'sometimes' : 'required').'|string'
        ];
    }
}

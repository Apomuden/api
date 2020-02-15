<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\Clinic;
use App\Repositories\RepositoryEloquent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClinicServiceMultipleRequest extends ApiFormRequest
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
        //$repository = new RepositoryEloquent(new Clinic);
        //$clinic = $repository->find((request()->input('clinic_id') ?? null));
        return [
            'clinic_id' => 'bail|integer|exists:clinics,id',
            'services'=> 'bail|required|array',
            'services.*.service_id'=>'bail|integer|exists:services,id',
            'services.*.billing_cycle_id'=> 'bail|integer|exists:billing_cycles,id',
            'services.*.billing_duration'=> 'bail|integer|min:1',
        ];
    }
}

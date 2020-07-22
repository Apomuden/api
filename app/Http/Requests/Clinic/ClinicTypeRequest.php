<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClinicTypeRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = $this->route('clinictype') ?? null;


        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUnique('clinic_types', 'name', $id),
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}

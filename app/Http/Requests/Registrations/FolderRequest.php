<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Repositories\HospitalEloquent;

class FolderRequest extends ApiFormRequest
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
        $repository = new HospitalEloquent(new Hospital());
        $hospital = $repository->first();

        $id = $this->route('folder') ?? null;
        return [
             'rack_no' => 'bail|sometimes|nullable',
             'folder_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|in:' . ($hospital->allowed_folder_type ?? 'INDIVIDUAL'),
             'status' => 'bail|sometimes|in:ACTIVE,INACTIVE,NULLIFIED,OLD'
        ];
    }
}

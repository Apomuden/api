<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ConsultingRoomRequest extends ApiFormRequest
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
        $id = $this->route('consultingroom') ?? null;
        return [
            'description' => 'bail|required|' . $this->softUnique('consulting_rooms', 'description', $id),
            'gender' => 'bail|required|set:MALE,FEMALE,BIGENDER',
            'status' => 'bail|required|in:ACTIVE,INACTIVE'
        ];
    }
}

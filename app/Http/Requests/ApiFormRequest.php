<?php
namespace App\Http\Requests;

use App\Http\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Support\Facades\Log;

abstract class ApiFormRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            ApiResponse::withValidationError($errors)
        );
    }
    protected function softUnique($table,$field,$id){
        return "unique:{$table},{$field},{$id},id,deleted_at,NULL";
    }
    protected function softUniqueWith($table,$fields,$id){
        $fields=trim($fields,",").',deleted_at';
       return "unique_with:{$table},{$fields}".($id?','.$id:'');
    }
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'deleted_at' => null
        ]);
    }
}

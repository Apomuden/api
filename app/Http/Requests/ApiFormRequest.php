<?php

namespace App\Http\Requests;

use App\Http\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
    protected function softExists($table, $field)
    {

        return "exists:$table,$field,deleted_at,NULL";
    }
    protected function softUnique($table, $field, $id)
    {
        $id= trim($id);
        if(!$id)
        $id=NULL;
        return "unique:{$table},{$field},{$id},id,deleted_at,NULL";
    }
    protected function softUniqueWith($table, $fields, $id)
    {
        $id = trim($id);
        if (!$id)
            $id = NULL;
        $fields = trim($fields, ",") . ',deleted_at';
        return "unique_with:{$table},{$fields}" . ($id ? ',' . $id : '');
    }
    protected function websiteRegEx()
    {
        return 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    }
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'deleted_at' => null
        ]);
    }
}

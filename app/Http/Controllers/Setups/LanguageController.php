<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DistrictRequest;
use App\Http\Requests\Setups\LanguageRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\Language;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $repository;

    public function __construct(Language $language)
    {
        $this->repository = new RepositoryEloquent($language);
    }

    function index()
    {
        return ApiResponse::withOk('Languages list', new GeneralCollection($this->repository->all('name')));
    }

    function show($language)
    {
        $language = $this->repository->show($language);//pass the country
        return $language ?
        ApiResponse::withOk('Language Found', new GeneralResource($language))
        : ApiResponse::withNotFound('Language Not Found');
    }

    function store(LanguageRequest $languageRequest)
    {
        try {
            $requestData = $languageRequest->all();
            $language = $this->repository->store($requestData);
            return ApiResponse::withOk('Language created', new GeneralResource($language->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(LanguageRequest $languageRequest, $language)
    {
        try {
            $language = $this->repository->update($languageRequest->all(), $language);
            return ApiResponse::withOk('Language updated', new GeneralResource($language));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Language deleted successfully');
    }
}

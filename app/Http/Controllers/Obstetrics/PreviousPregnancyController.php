<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\PreviousPregnancyRequest;
use App\Http\Resources\Obstetrics\PreviousPregnancyCollection;
use App\Http\Resources\Obstetrics\PreviousPregnancyResource;
use App\Models\Obstetrics\PreviousPregnancy;
use App\Repositories\RepositoryEloquent;
use Exception;

class PreviousPregnancyController extends Controller
{
    protected $repository;

    public function __construct(PreviousPregnancy $pregnancy)
    {
        $this->repository = new RepositoryEloquent($pregnancy);
    }

    public function index()
    {

        return ApiResponse::withOk('PreviousPregnancys list', new PreviousPregnancyCollection($this->repository->all('name')));
    }

    public function show($pregnancy)
    {
        $pregnancy = $this->repository->show($pregnancy);
        return $pregnancy ?
            ApiResponse::withOk('PreviousPregnancy Found', new PreviousPregnancyResource($pregnancy))
            : ApiResponse::withNotFound('PreviousPregnancy Not Found');
    }

    public function store(PreviousPregnancyRequest $request)
    {
        try {
            $requestData = $request->all();
            $pregnancy = $this->repository->store($requestData);
            return ApiResponse::withOk('PreviousPregnancy created', new PreviousPregnancyResource($pregnancy->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(PreviousPregnancyRequest $request, $pregnancy)
    {
        try {
            $pregnancy = $this->repository->update($request->all(), $pregnancy);
            return ApiResponse::withOk('PreviousPregnancy updated', new PreviousPregnancyResource($pregnancy));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('PreviousPregnancy deleted successfully');
    }
}

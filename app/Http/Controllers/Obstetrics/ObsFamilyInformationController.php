<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\ObsFamilyInformationRequest;
use App\Http\Resources\Obstetrics\ObsFamilyInformationResource;
use App\Models\Obstetrics\ObsFamilyInformation;
use App\Repositories\RepositoryEloquent;
use Exception;

class ObsFamilyInformationController
{
    protected $repository;

    public function __construct(ObsFamilyInformation $information)
    {
        $this->repository = new RepositoryEloquent($information);
    }

    public function index()
    {

        return ApiResponse::withOk('Family information list', ObsFamilyInformationResource::collection($this->repository->all('name')));
    }

    public function show($id)
    {
        $info = $this->repository->show($id);
        return $info ?
            ApiResponse::withOk('Family information Found', new ObsFamilyInformationResource($info))
            : ApiResponse::withNotFound('Family information Not Found');
    }

    public function store(ObsFamilyInformationRequest $request)
    {
//        try {
            $info = $this->repository->store($request->all());
            return ApiResponse::withOk('Family information created', new ObsFamilyInformationResource($info));
//        } catch (Exception $e) {
//            return ApiResponse::withException($e);
//        }
    }

    public function update(ObsFamilyInformationRequest $request, $id)
    {
        try {
            $info = $this->repository->update($request->all(), $id);
            return ApiResponse::withOk('Family information updated', new ObsFamilyInformationResource($info));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Family information deleted successfully');
    }
}

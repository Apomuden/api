<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\StaffTypeRequest;
use App\Http\Resources\StaffTypCollection;
use App\Http\Resources\StaffTypeCollection;
use App\Http\Resources\StaffTypeResource;
use App\Models\StaffType;
use App\Repositories\RepositoryEloquent;
use Exception;

class StaffTypeController extends Controller
{
    protected $repository;

    public function __construct(StaffType $type)
    {
        $this->repository = new RepositoryEloquent($type);
    }

    function index()
    {
        return ApiResponse::withOk('Staff Type list', new StaffTypeCollection($this->repository->all('name')));
    }

    function show($staffTypeRequest)
    {
        $staffTypeRequest = $this->repository->show($staffTypeRequest);//pass the country
        return $staffTypeRequest ?
        ApiResponse::withOk('Staff Type Found', new StaffTypeResource($staffTypeRequest))
        : ApiResponse::withNotFound('Staff Type Not Found');
    }

    function store(StaffTypeRequest $staffTypeRequest)
    {
        try {
            $requestData = $staffTypeRequest->all();
            $type = $this->repository->store($requestData);
            return ApiResponse::withOk('Staff Type created', new StaffTypeResource($type->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(StaffTypeRequest $staffTypeRequest, $stafftype)
    {
        try {
            $stafftype = $this->repository->update($staffTypeRequest->all(), $stafftype);
            return ApiResponse::withOk('Staff Type updated', new StaffTypeResource($stafftype));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Staff type deleted successfully');
    }
}

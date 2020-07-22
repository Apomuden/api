<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeGroupRequest;
use App\Http\Resources\AgeGroupCollection;
use App\Http\Resources\AgeGroupResource;
use App\Models\AgeGroup;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class AgeGroupController extends Controller
{
    protected $repository;

    public function __construct(AgeGroup $ageGroup)
    {
        $this->repository = new RepositoryEloquent($ageGroup);
    }

    function index()
    {

        return ApiResponse::withOk('AgeGroup list', new AgeGroupCollection($this->repository->all('name')));
    }

    function show($AgeGroup)
    {
        $AgeGroup = $this->repository->show($AgeGroup);//pass the country
        return $AgeGroup ?
        ApiResponse::withOk('AgeGroup Found', new AgeGroupResource($AgeGroup))
        : ApiResponse::withNotFound('AgeGroup Not Found');
    }

    function store(AgeGroupRequest $AgeGroupRequest)
    {
        try {
            $requestData = $AgeGroupRequest->all();

            $AgeGroup = $this->repository->store($requestData);
            return ApiResponse::withOk('AgeGroup created', new AgeGroupResource($AgeGroup->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(AgeGroupRequest $AgeGroupRequest, $id)
    {
        try {
            $AgeGroup = $this->repository->update($AgeGroupRequest->all(), $id);

            return ApiResponse::withOk('AgeGroup updated', new AgeGroupResource($AgeGroup));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('AgeGroup deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeGroupRequest;
use App\Http\Requests\Setups\IDTypeRequest;
use App\Http\Resources\IDTypeCollection;
use App\Http\Resources\IDTypeResource;
use App\Models\IdType;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class IDTypeController extends Controller
{
    protected $repository;

    public function __construct(IdType $idType)
    {
        $this->repository = new RepositoryEloquent($idType);
    }

    function index()
    {

        return ApiResponse::withOk('Id Type list', new IDTypeCollection($this->repository->all('name')));
    }

    function show($idType)
    {
        $idType = $this->repository->show($idType);//pass the country
        return $idType ?
        ApiResponse::withOk('Id Type Found', new IDTypeResource($idType))
        : ApiResponse::withNotFound('ID Type Not Found');
    }

    function store(IDTypeRequest $idTypeRequest)
    {
        try {
            $requestData = $idTypeRequest->all();

            $idType = $this->repository->store($requestData);
            return ApiResponse::withOk('Id Type created', new IDTypeResource($idType->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(IDTypeRequest $iDTypeRequest, $idType)
    {
        try {
            $idType = $this->repository->update($iDTypeRequest->all(), $idType);

            return ApiResponse::withOk('Id Type updated', new IDTypeResource($idType));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('ID Type deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\HospitalServiceRequest;
use App\Http\Requests\Setups\StaffTypeRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\Hospital;
use App\Models\HospitalService;
use App\Repositories\RepositoryEloquent;
use Exception;

class HospitalServiceController extends Controller
{
    protected $repository;

    public function __construct(HospitalService $hospitalService)
    {
        $this->repository = new RepositoryEloquent($hospitalService);
    }

    function index()
    {
        return ApiResponse::withOk('Hospital service list', new GeneralCollection($this->repository->all('name')));
    }

    function show($hospitalService)
    {
        $hospitalService = $this->repository->show($hospitalService);//pass the country
        return $hospitalService ?
        ApiResponse::withOk('Hospital Found', new GeneralResource($hospitalService))
        : ApiResponse::withNotFound('Hospital service Not Found');
    }

    function store(HospitalServiceRequest $hospitalServiceRequest)
    {
        try {
            $requestData = $hospitalServiceRequest->all();
            $hospitalService = $this->repository->store($requestData);
            return ApiResponse::withOk('Hospital service created', new GeneralResource($hospitalService->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(HospitalServiceRequest $hospitalServiceRequest, $hospitalService)
    {
        try {
            $hospitalService = $this->repository->update($hospitalServiceRequest->all(), $hospitalService);
            return ApiResponse::withOk('Hospital service updated', new GeneralResource($hospitalService));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Hospital service deleted successfully');
    }
}

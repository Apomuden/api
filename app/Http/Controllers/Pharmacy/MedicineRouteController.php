<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\MedicineRouteRequest;
use App\Http\Resources\Pharmacy\MedicineRouteCollection;
use App\Http\Resources\Pharmacy\MedicineRouteResource;
use App\Models\MedicineRoute;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class MedicineRouteController extends Controller
{
    protected $repository;

    public function __construct(MedicineRoute $MedicineRoute)
    {
        $this->repository = new RepositoryEloquent($MedicineRoute);
    }

    public function index()
    {

        return ApiResponse::withOk('Medicine Routes list', new MedicineRouteCollection($this->repository->all('name')));
    }

    public function show($MedicineRoute)
    {
        $MedicineRoute = $this->repository->show($MedicineRoute);
        return $MedicineRoute ?
            ApiResponse::withOk('Medicine Route Found', new MedicineRouteResource($MedicineRoute))
            : ApiResponse::withNotFound('Medicine Route Not Found');
    }

    public function store(MedicineRouteRequest $MedicineRouteRequest)
    {
        try {
            $requestData = $MedicineRouteRequest->all();
            $MedicineRoute = $this->repository->store($requestData);
            return ApiResponse::withOk('Medicine Route created', new MedicineRouteResource($MedicineRoute->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(MedicineRouteRequest $MedicineRouteRequest, $MedicineRoute)
    {
        try {
            $MedicineRoute = $this->repository->update($MedicineRouteRequest->all(), $MedicineRoute);
            return ApiResponse::withOk('Medicine Route updated', new MedicineRouteResource($MedicineRoute));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Medicine Route deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\MeasurementRequest;
use App\Http\Resources\MeasurementCollection;
use App\Http\Resources\MeasurementResource;
use App\Models\Measurement;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    protected $repository;

    public function __construct(Measurement $measurement)
    {
        $this->repository = new RepositoryEloquent($measurement);
    }

    public function index()
    {

        return ApiResponse::withOk('Measurement list', new MeasurementCollection($this->repository->all('name')));
    }

    public function show($measurement)
    {
        $measurement = $this->repository->show($measurement);
        return $measurement ?
            ApiResponse::withOk('Measurement Found', new MeasurementResource($measurement))
            : ApiResponse::withNotFound('Measurement Not Found');
    }

    public function store(MeasurementRequest $measurementRequest)
    {
        try {
            $requestData = $measurementRequest->all();
            $measurement = $this->repository->store($requestData);
            return ApiResponse::withOk('Measurement created', new MeasurementResource($measurement->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(MeasurementRequest $measurementRequest, $measurement)
    {
        try {
            $measurement = $this->repository->update($measurementRequest->all(), $measurement);
            return ApiResponse::withOk('Measurement updated', new MeasurementResource($measurement));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Measurement deleted successfully');
    }
}

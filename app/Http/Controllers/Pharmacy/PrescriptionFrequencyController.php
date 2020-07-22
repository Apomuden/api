<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\PrescriptionFrequencyRequest; //TODO: Make Sure to change to the correct Request namespace
use App\Http\Resources\Pharmacy\PrescriptionFrequencyCollection; //TODO: Make Sure to change to the correct Collection namespace
use App\Http\Resources\Pharmacy\PrescriptionFrequencyResource; //TODO: Make Sure to change to the correct Resource namespace
use App\Models\PrescriptionFrequency; //TODO: Make Sure to change to the correct Model namespace
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class PrescriptionFrequencyController extends Controller
{
    protected $repository;

    public function __construct(PrescriptionFrequency $PrescriptionFrequency)
    {
        $this->repository = new RepositoryEloquent($PrescriptionFrequency);
    }

    public function index()
    {

        return ApiResponse::withOk('PrescriptionFrequencys list', new PrescriptionFrequencyCollection($this->repository->all('name')));
    }

    public function show($PrescriptionFrequency)
    {
        $PrescriptionFrequency = $this->repository->show($PrescriptionFrequency);
        return $PrescriptionFrequency ?
            ApiResponse::withOk('PrescriptionFrequency Found', new PrescriptionFrequencyResource($PrescriptionFrequency))
            : ApiResponse::withNotFound('PrescriptionFrequency Not Found');
    }

    public function store(PrescriptionFrequencyRequest $PrescriptionFrequencyRequest)
    {
        try {
            $requestData = $PrescriptionFrequencyRequest->all();
            $PrescriptionFrequency = $this->repository->store($requestData);
            return ApiResponse::withOk('PrescriptionFrequency created', new PrescriptionFrequencyResource($PrescriptionFrequency->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(PrescriptionFrequencyRequest $PrescriptionFrequencyRequest, $PrescriptionFrequency)
    {
        try {
            $PrescriptionFrequency = $this->repository->update($PrescriptionFrequencyRequest->all(), $PrescriptionFrequency);
            return ApiResponse::withOk('PrescriptionFrequency updated', new PrescriptionFrequencyResource($PrescriptionFrequency));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('PrescriptionFrequency deleted successfully');
    }
}

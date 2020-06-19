<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\DeliveryOutcomeRequest;
use App\Http\Resources\Obstetrics\DeliveryOutcomeCollection;
use App\Http\Resources\Obstetrics\DeliveryOutcomeResource;
use App\Models\Obstetrics\DeliveryOutcome;
use App\Repositories\RepositoryEloquent;
use Exception;

class DeliveryOutcomeController extends Controller
{
    protected $repository;

    public function __construct(DeliveryOutcome $DeliveryOutcome)
    {
        $this->repository = new RepositoryEloquent($DeliveryOutcome);
    }

    public function index()
    {

        return ApiResponse::withOk('DeliveryOutcomes list', new DeliveryOutcomeCollection($this->repository->all('name')));
    }

    public function show($DeliveryOutcome)
    {
        $DeliveryOutcome = $this->repository->show($DeliveryOutcome);
        return $DeliveryOutcome ?
            ApiResponse::withOk('DeliveryOutcome Found', new DeliveryOutcomeResource($DeliveryOutcome))
            : ApiResponse::withNotFound('DeliveryOutcome Not Found');
    }

    public function store(DeliveryOutcomeRequest $DeliveryOutcomeRequest)
    {
        try {
            $requestData = $DeliveryOutcomeRequest->all();
            $DeliveryOutcome = $this->repository->store($requestData);
            return ApiResponse::withOk('DeliveryOutcome created', new DeliveryOutcomeResource($DeliveryOutcome->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(DeliveryOutcomeRequest $DeliveryOutcomeRequest, $DeliveryOutcome)
    {
        try {
            $DeliveryOutcome = $this->repository->update($DeliveryOutcomeRequest->all(), $DeliveryOutcome);
            return ApiResponse::withOk('DeliveryOutcome updated', new DeliveryOutcomeResource($DeliveryOutcome));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('DeliveryOutcome deleted successfully');
    }
}

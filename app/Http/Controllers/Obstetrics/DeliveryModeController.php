<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\DeliveryModeRequest;
use App\Http\Resources\Obstetrics\DeliveryModeCollection;
use App\Http\Resources\Obstetrics\DeliveryModeResource;
use App\Models\Obstetrics\DeliveryMode;
use App\Repositories\RepositoryEloquent;
use Exception;

class DeliveryModeController extends Controller
{
    protected $repository;

    public function __construct(DeliveryMode $mode)
    {
        $this->repository = new RepositoryEloquent($mode);
    }

    public function index()
    {

        return ApiResponse::withOk('DeliveryModes list', new DeliveryModeCollection($this->repository->all('name')));
    }

    public function show($mode)
    {
        $mode = $this->repository->show($mode);
        return $mode ?
            ApiResponse::withOk('DeliveryMode Found', new DeliveryModeResource($mode))
            : ApiResponse::withNotFound('DeliveryMode Not Found');
    }

    public function store(DeliveryModeRequest $request)
    {
        try {
            $requestData = $request->all();
            $mode = $this->repository->store($requestData);
            return ApiResponse::withOk('DeliveryMode created', new DeliveryModeResource($mode->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(DeliveryModeRequest $request, $mode)
    {
        try {
            $mode = $this->repository->update($request->all(), $mode);
            return ApiResponse::withOk('DeliveryMode updated', new DeliveryModeResource($mode));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('DeliveryMode deleted successfully');
    }
}

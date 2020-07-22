<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\PaymentStyleRequest;
use App\Http\Requests\Setups\StaffTypeRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\PaymentStyle;
use App\Repositories\RepositoryEloquent;
use Exception;

class PaymentStyleController extends Controller
{
    protected $repository;

    public function __construct(PaymentStyle $style)
    {
        $this->repository = new RepositoryEloquent($style);
    }

    function index()
    {
        return ApiResponse::withOk('Staff Type list', new GeneralCollection($this->repository->all('name')));
    }

    function show($paymentStyleRequest)
    {
        $paymentStyleRequest = $this->repository->show($paymentStyleRequest);//pass the country
        return $paymentStyleRequest ?
        ApiResponse::withOk('Staff Type Found', new GeneralResource($paymentStyleRequest))
        : ApiResponse::withNotFound('Staff Type Not Found');
    }

    function store(PaymentStyleRequest $paymentStyleRequest)
    {
        try {
            $requestData = $paymentStyleRequest->all();
            $type = $this->repository->store($requestData);
            return ApiResponse::withOk('Staff Type created', new GeneralResource($type->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(PaymentStyleRequest $paymentStyleRequest, $paymentStyle)
    {
        try {
            $paymentStyle = $this->repository->update($paymentStyleRequest->all(), $paymentStyle);
            return ApiResponse::withOk('Staff Type updated', new GeneralResource($paymentStyle));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Payment style deleted successfully');
    }
}

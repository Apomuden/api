<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\PaymentChannelRequest;
use App\Http\Resources\PaymentChannelResource;
use App\Models\PaymentChannel;
use App\Repositories\RepositoryEloquent;
use Exception;

class PaymentChannelController extends Controller
{
    protected $repository;

    public function __construct(PaymentChannel $paymentChannel)
    {
        $this->repository = new RepositoryEloquent($paymentChannel);
    }

    function index()
    {
        return ApiResponse::withOk('Payment Channel list', PaymentChannelResource::collection($this->repository->all('name')));
    }

    function show($paymentChannel)
    {
        $paymentChannel = $this->repository->show($paymentChannel);//pass the country
        return $paymentChannel ?
        ApiResponse::withOk('Payment Channel Found', new PaymentChannelResource($paymentChannel))
        : ApiResponse::withNotFound('Payment Channel Not Found');
    }

    function store(PaymentChannelRequest $paymentChannelRequest)
    {
        try {
            $requestData = $paymentChannelRequest->all();
            $paymentChannel = $this->repository->store($requestData);
            return ApiResponse::withOk('Payment Channel created', new PaymentChannelResource($paymentChannel->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(PaymentChannelRequest $paymentChannelRequest, $paymentChannel)
    {
        try {
            $paymentChannel = $this->repository->update($paymentChannelRequest->all(), $paymentChannel);
            return ApiResponse::withOk('Payment Channel updated', new PaymentChannelResource($paymentChannel));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Payment Channel deleted successfully');
    }
}

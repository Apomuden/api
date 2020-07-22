<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\FundingTypeRequest;
use App\Http\Resources\FundingTypeCollection;
use App\Http\Resources\FundingTypeResource;
use App\Models\FundingType;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Exception;

class FundingTypeController extends Controller
{
    protected $repository;

    public function __construct(FundingType $fundingType)
    {
        $this->repository = new RepositoryEloquent($fundingType, true, ['sponsorship_type','billing_system','billing_cycle','payment_style','payment_channel']);
    }

    function index()
    {
        return ApiResponse::withOk('Funding Type list', new FundingTypeCollection($this->repository->all('name')));
    }

    function show($fundingType)
    {
        $fundingType = $this->repository->show($fundingType);//pass the country
        return $fundingType ?
        ApiResponse::withOk('Funding Type Found', new FundingTypeResource($fundingType))
        : ApiResponse::withNotFound('Funding Type Not Found');
    }
    function store(FundingTypeRequest $fundingTypeRequest)
    {
        try {
            $requestData = $fundingTypeRequest->all();
            $fundingType = $this->repository->store($requestData);
            return ApiResponse::withOk('Funding Type created', new FundingTypeResource($fundingType->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    function update(FundingTypeRequest $fundingTypeRequest, $fundingType)
    {
        try {
            $fundingType = $this->repository->update($fundingTypeRequest->all(), $fundingType);
            return ApiResponse::withOk('Funding Type updated', new FundingTypeResource($fundingType));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Funding type deleted successfully');
    }
    function showBySponsorshipType($sponsorshiptype)
    {
        $this->repository->setModel(new SponsorshipType());

        $fundingTypes = $this->repository->find($sponsorshiptype)->funding_types()->active()->orderBy('name')->get();
        return $fundingTypes ?
        ApiResponse::withOk('Available Funding Types', new FundingTypeCollection($fundingTypes))
        : ApiResponse::withNotFound('Funding Types Not Found');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\SponsorshipPolicyRequest;
use App\Http\Resources\SponsorshipPolicyResource;
use App\Models\SponsorshipPolicy;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class SponsorshipPolicyController extends Controller
{
    protected $repository;
    public function __construct(SponsorshipPolicy $sponsorshipPolicy)
    {
        $with = [
            'billing_sponsor'
        ];
        $this->repository = new RepositoryEloquent($sponsorshipPolicy, true, $with);
    }
    public function index()
    {
        $policies = $this->repository->all('name');
        return ApiResponse::withOk('Sponsor policies list', SponsorshipPolicyResource::collection($policies));
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store(SponsorshipPolicyRequest $request)
    {
        $policy = $this->repository->store($request->all());
        return ApiResponse::withOk('Sponsor policy created', new SponsorshipPolicyResource($policy->refresh()));
    }

    /**
     * Display the specified resource.

     */
    public function show($sponsorpolicy)
    {
        $policy = $this->repository->find($sponsorpolicy);
        return
        $policy ? ApiResponse::withOk('Sponsor policy found', new SponsorshipPolicyResource($policy)) :
        ApiResponse::withNotFound('Sponsor policy not found');
    }

    /**
     * Update the specified resource in storage.

     */
    public function update(SponsorshipPolicyRequest $request, $sponsorpolicy)
    {
        $policy = $this->repository->update($request->all(), $sponsorpolicy);
        return ApiResponse::withOk('Sponsor policy updated', new SponsorshipPolicyResource($policy));
    }

    /**
     * Remove the specified resource from storage.

     */
    public function destroy($sponsorpolicy)
    {
        $this->repository->delete($sponsorpolicy);
        return ApiResponse::withOk('Sponsor policy deleted');
    }
}

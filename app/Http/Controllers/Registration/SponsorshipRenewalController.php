<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\SponsorshipRenewalRequest;
use App\Http\Resources\Registrations\SponsorshipRenewalResource;
use App\Models\PatientSponsor;
use App\Models\SponsorshipRenewal;
use App\Repositories\RepositoryEloquent;
use Facade\FlareClient\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SponsorshipRenewalController extends Controller
{
    protected $repository;
    public function __construct(SponsorshipRenewal $SponsorshipRenewal)
    {
        $this->repository = new RepositoryEloquent($SponsorshipRenewal);
    }
    public function index()
    {
        return ApiResponse::withOk('Sponsorship Renewals list', SponsorshipRenewalResource::collection($this->repository->all('member_id')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SponsorshipRenewalRequest $request)
    {
        $repo = new RepositoryEloquent(new PatientSponsor());
        $sponsor = $repo->findWhere(['patient_id' => $request['patient_id'],'billing_sponsor_id' => $request['billing_sponsor_id']])->orWhere(['id' => $request['patient_sponsor_id']])->first();
        if (!$sponsor) {
            return ApiResponse::withValidationError('Patient has no sponsor');
        }
        $sponsorRequest = $request;
        $request['renewed_by'] = Auth::id();
        $sponsorRequest['expiry_date'] = $request['renewal_end_date'];
        $sponsorRequest['old_expiry_date'] = $sponsor->expiry_date;
        unset($sponsorRequest['renewal_start_date'], $sponsorRequest['renewal_end_date']);
        try {
            DB::beginTransaction();
            $repo->update($sponsorRequest->all(), $sponsor->id);
            $sponsorshipRenewal = $this->repository->store($request->all());
            DB::commit();
            return ApiResponse::withOk('Patient sponsorship renewed', new SponsorshipRenewalResource($sponsorshipRenewal->refresh()));
        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponse::withException($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $SponsorshipRenewal
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($SponsorshipRenewal)
    {
        $SponsorshipRenewal = $this->repository->find($SponsorshipRenewal);
        return ApiResponse::withOk('Sponsorship renewal found', new SponsorshipRenewalResource($SponsorshipRenewal));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SponsorshipRenewal
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SponsorshipRenewalRequest $request, $SponsorshipRenewal)
    {
        $SponsorshipRenewal = $this->repository->update($request->all(), $SponsorshipRenewal);
        return ApiResponse::withOk('Sponsorship Renewal updated', new SponsorshipRenewalResource($SponsorshipRenewal));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $SponsorshipRenewal
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($SponsorshipRenewal)
    {
        $SponsorshipRenewal = $this->repository->delete($SponsorshipRenewal);
        return ApiResponse::withOk('Sponsor Renewal deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\PatientSponsorRequest;
use App\Http\Resources\PatientSponsorResource;
use App\Models\PatientSponsor;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class PatientSponsorController extends Controller
{
    protected $repository;

    public function __construct(PatientSponsor $patientSponsor)
    {
        $with = [
            'sponsorship_type',
            'billing_sponsor',
            'sponsorship_policy',
            'relationship',
            'user',

        ];
        $this->repository=new RepositoryEloquent($patientSponsor,true,$with);
    }
    public function index()
    {
        return ApiResponse::withOk('Patient Sponsors List',PatientSponsorResource::collection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientSponsorRequest $request)
    {
        $patientSponsor=$this->repository->store($request->all());
        return ApiResponse::withOk("Patient Sponsor created", new PatientSponsorResource($patientSponsor->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($patientsponsor)
    {
        $patientSponsor=$this->repository->find($patientsponsor);
        return
            $patientSponsor?
                ApiResponse::withOk("Patient Sponsor found", new PatientSponsorResource($patientSponsor))
                :
                ApiResponse::withOk("Patient Sponsor not found");

    }

    public function update(PatientSponsorRequest $request, $patientsponsor)
    {
        $patientSponsor=$this->repository->update($request->all(),$patientsponsor);
        return ApiResponse::withOk("Patient Sponsor updated", new PatientSponsorResource($patientSponsor));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Patient Sponsor deleted successfully');
    }
}

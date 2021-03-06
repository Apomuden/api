<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\BillingSponsorRequest;
use App\Http\Resources\BillingSponsorResource;
use App\Models\BillingSponsor;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class BillingSponsorController extends Controller
{
    protected $repository;

    public function __construct(BillingSponsor $billingSponsor)
    {
        $this->repository=new RepositoryEloquent($billingSponsor,true,['company','sponsorship_type']);
    }
    public function index()
    {
        return ApiResponse::withOk('Billing Sponsors List',BillingSponsorResource::collection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillingSponsorRequest $request)
    {
       $billingSponsor=$this->repository->store($request->all());
       return ApiResponse::withOk("Billing Sponsor created", new BillingSponsorResource($billingSponsor->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($billingsponsor)
    {
        $billingSponsor=$this->repository->find($billingsponsor);
        return ApiResponse::withOk("Billing Sponsor found", new BillingSponsorResource($billingSponsor));
    }

    public function update(BillingSponsorRequest $request, $billingsponsor)
    {
        $billingSponsor=$this->repository->update($request->all(),$billingsponsor);
        return ApiResponse::withOk("Billing Sponsor updated", new BillingSponsorResource($billingSponsor));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

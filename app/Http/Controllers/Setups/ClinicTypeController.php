<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicTypeRequest;
use App\Http\Resources\ClinicTypeResource;
use App\Models\ClinicType;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ClinicTypeController extends Controller
{
    protected $repository;
    public function __construct(ClinicType $clinicType)
    {
        $this->repository = new RepositoryEloquent($clinicType);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Clinic Type list', ClinicTypeResource::collection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClinicTypeRequest $request)
    {
       $record=$this->repository->store($request->all());
       return ApiResponse::withOk('Clinic Type created',new ClinicTypeResource($record->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->show($id);
        return ApiResponse::withOk('Found Clinic Type',new ClinicTypeResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicTypeRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Found Clinic Type', new ClinicTypeResource($record));
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
        return ApiResponse::withOk('Clinic Type deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisMedicineRequest;
use App\Http\Resources\NhisMedicineResource;
use App\Models\NhisMedicine;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class NhisMedicineController extends Controller
{
    private $repository=null;
    public function __construct(NhisMedicine $nhisMedicine)
    {
      $this->repository=new RepositoryEloquent($nhisMedicine);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Nhis Medicines',NhisMedicineResource::collection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NhisMedicineRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Nhis Medicine Created',new NhisMedicineResource($record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->find($id);
        return ApiResponse::withOk('Nhis Medicine Created', new NhisMedicineResource($record->refresh()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NhisMedicineRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Nhis Medicine updated', new NhisMedicineResource($record));
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
        return ApiResponse::withOk('Nhis Medicine deleted');
    }
}

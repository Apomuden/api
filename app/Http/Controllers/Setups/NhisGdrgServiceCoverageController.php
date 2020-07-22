<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisGdrgServiceCoverageRequest;
use App\Http\Resources\NhisGdrgServiceCoverageResource;
use App\Models\NhisGdrgServiceCoverage;
use App\Repositories\RepositoryEloquent;
use Exception;

class NhisGdrgServiceCoverageController extends Controller
{
    protected $repository;

    public function __construct(NhisGdrgServiceCoverage $nhisGdrgServiceCoverage)
    {
        $this->repository = new RepositoryEloquent($nhisGdrgServiceCoverage);
    }

    function index()
    {

        return ApiResponse::withOk('Nhis Gdrg Service Coverage list', NhisGdrgServiceCoverageResource::collection($this->repository->all('name')));
    }

    function show($id)
    {
        $nhisGdrgServiceCoverage = $this->repository->show($id);//pass the country
        return $nhisGdrgServiceCoverage ?
        ApiResponse::withOk('Nhis Gdrg Service Coverage Found', new NhisGdrgServiceCoverageResource($nhisGdrgServiceCoverage))
        : ApiResponse::withNotFound('Nhis Gdrg Service Coverage Found');
    }

    function store(NhisGdrgServiceCoverageRequest $request)
    {
        //try{
           $payload = $request->all();

           $nhisGdrgServiceCoverage = $this->repository->store($payload);
        return ApiResponse::withOk('Nhis Gdrg Service Coverage created', new NhisGdrgServiceCoverageResource($nhisGdrgServiceCoverage->refresh()));
       /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
        } */
    }

    function update(NhisGdrgServiceCoverageRequest $request, $id)
    {
        try {
            $nhisGdrgServiceCoverage = $this->repository->update($request->all(), $id);

            return ApiResponse::withOk('Nhis Gdrg Service Coverage updated', new NhisGdrgServiceCoverageResource($nhisGdrgServiceCoverage));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Nhis Gdrg Service Coverage deleted successfully');
    }
}

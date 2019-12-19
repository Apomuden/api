<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\FileResolver;
use App\Http\Requests\Setups\HospitalRequest;
use App\Http\Requests\Setups\HospitalUpdateRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Repositories\HospitalEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    protected $repository;

    public function __construct(Hospital $hospital)
    {
        $this->repository= new HospitalEloquent($hospital);
    }

    public function index()
    {
        //
    }



    public function store(HospitalRequest $request)
    {
        $requestData=ApiRequest::asArray($request);

        //$requestData['logo']=FileResolver::base64ToFile($request->logo);

       $response=$this->repository->store($requestData);

       return  ApiResponse::withOk('Hospital created',new HospitalResource($response));

    }


    public function show()
    {
       return  ApiResponse::withOk('Hospital Found',new HospitalResource($this->repository->first()));
    }

    public function update(HospitalRequest $request)
    {
        $requestData=ApiRequest::asArray($request);


        //$requestData['logo']=FileResolver::base64ToFile($request->logo);
        $response=$this->repository->update($requestData);

        return  ApiResponse::withOk('Hospital updated',new HospitalResource($response));
    }


    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisAccreditationSettingRequest;
use App\Http\Resources\NhisAccreditationSettingResource;
use App\Models\NhisAccreditationSetting;
use App\Repositories\NhisAccreditationSettingEloquent;

class NhisAccreditationSettingController extends Controller
{
    protected $repository;

    public function __construct(NhisAccreditationSetting $NhisAccreditationSetting)
    {
        $this->repository = new NhisAccreditationSettingEloquent($NhisAccreditationSetting, ['nhis_provider_level']);
    }

    public function index()
    {
        //
    }



    public function store(NhisAccreditationSettingRequest $request)
    {
        $requestData = ApiRequest::asArray($request);

        //$requestData['logo']=FileResolver::base64ToFile($request->logo);

        if ($this->repository->first()) {
            return ApiResponse::withNotOk('Nhis Accreditation Setting is already setup,kindly update');
        }

        $response = $this->repository->store($requestData);

        return  ApiResponse::withOk('Nhis Accreditation Setting created', new NhisAccreditationSettingResource($response->refresh()));
    }


    public function show()
    {
        $record = $this->repository->first();
        if ($record) {
            return  ApiResponse::withOk('Nhis Accreditation Setting Found', new NhisAccreditationSettingResource($record));
        } else {
            return ApiResponse::withNotFound('No Record Found');
        }
    }

    public function update(NhisAccreditationSettingRequest $request)
    {
        $requestData = ApiRequest::asArray($request);

        //$requestData['logo']=FileResolver::base64ToFile($request->logo);
        $response = $this->repository->update($requestData);

        return  ApiResponse::withOk('Nhis Accreditation Setting updated', new NhisAccreditationSettingResource($response));
    }


    public function destroy($id)
    {
        //
    }
}

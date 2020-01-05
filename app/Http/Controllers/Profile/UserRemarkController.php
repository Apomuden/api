<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\UserRemarkRequest;
use App\Http\Resources\UserRemarkResource;
use App\Models\UserRemark;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRemarkController extends Controller
{
    protected $repository;
    public function __construct(UserRemark $userRemark)
    {
       $this->repository=new RepositoryEloquent($userRemark,true,['remarker']);
    }

    public function index()
    {
       //DB::enableQueryLog();
       $remarks=$this->repository->all('type');
       //return [DB::getQueryLog()];
       return ApiResponse::withOk('User remarks list',UserRemarkResource::collection($remarks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRemarkRequest $request)
    {
       $remark=$this->repository->store($request->all());
       return ApiResponse::withOk('User remark created',new UserRemarkResource($remark->refresh()));
    }

    public function show($remark)
    {
       $remark=$this->repository->find($remark);
       return ApiResponse::withOk('User remark found',new UserRemarkResource($remark));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRemarkRequest $request,$remark)
    {
       $remark=$this->repository->update($request->all(),$remark);
       return ApiResponse::withOk('User remark updated',new UserRemarkResource($remark));
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

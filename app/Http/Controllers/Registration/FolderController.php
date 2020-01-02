<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\FolderRequest;
use App\Http\Resources\Registrations\FolderResource;
use App\Models\Folder;
use App\Repositories\RepositoryEloquent;

class FolderController extends Controller
{
    protected $repository;

    public function __construct(Folder $folder)
    {
       $this->repository=new RepositoryEloquent($folder);
    }

    public function index()
    {
       return ApiResponse::withOk('Folders List',FolderResource::collection($this->repository->all('surname')));
    }

    public function store(FolderRequest $request)
    {
        $folder=$this->repository->store($request->all());
       return ApiResponse::withOk("Folder created",new FolderResource($folder->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($folder)
    {
        $folder=$this->repository->find($folder);
        return ApiResponse::withOk('Folder found',new FolderResource($folder));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FolderRequest $request, $folder)
    {
        $folder=$this->repository->update($request->all(),$folder);
        return ApiResponse::withOk('Folder updated',new FolderResource($folder));
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

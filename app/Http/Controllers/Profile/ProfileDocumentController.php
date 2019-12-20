<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfileDocumentRequest;
use App\Http\Resources\ProfileDocumentCollection;
use App\Http\Resources\ProfileDocumentResource;
use App\Models\User;
use App\Models\UserDocument;
use App\Repositories\RepositoryEloquent;
use Exception;

class ProfileDocumentController extends Controller
{
    protected $repository;

    public function __construct(UserDocument $profileDocument)
    {
        $this->repository= new RepositoryEloquent($profileDocument,true,'user');
    }

    function index(){

        return ApiResponse::withOk('Profile Document list',new ProfileDocumentCollection($this->repository->all('name')));
    }

    function show($profileDocument){
        $profileDocument=$this->repository->show($profileDocument);//pass the country
        return $profileDocument?
        ApiResponse::withOk('Profile Document Found',new ProfileDocumentResource($profileDocument))
        : ApiResponse::withNotFound('Profile Document Not Found');
    }

   function store(ProfileDocumentRequest $profileDocument){
       try{
           $requestData=$profileDocument->all();

           $profileDocument=$this->repository->store($requestData);
        return ApiResponse::withOk('Profile Document created',new ProfileDocumentResource($profileDocument->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(ProfileDocumentRequest $profileDocumentRequest,$profileDocument){
       try{
        $profileDocument=$this->repository->update($profileDocumentRequest->all(),$profileDocument);

        return ApiResponse::withOk('Profile Document updated',new ProfileDocumentResource($profileDocument));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

   function showByProfile($profile){
       $this->repository->setModel(new User,['documents'=>function($query){
           $query->active()->orderBy('name');
       }]);
       $documents=$this->repository->find($profile)->documents??null;

       return $documents?
       ApiResponse::withOk('Available Documents Found',new ProfileDocumentCollection($documents))
       : ApiResponse::withNotFound('Profile Documents Not Found');
   }


}

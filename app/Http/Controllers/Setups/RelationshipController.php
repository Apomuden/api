<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\RelationshipRequest;
use App\Http\Requests\Setups\TitleRequest;
use App\Http\Requests\Setups\TownRequest;

use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\Relationship;

use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    protected $repository;

    public function __construct(Relationship $relationship)
    {
        $this->repository= new RepositoryEloquent($relationship);
    }

    function index(){

        return ApiResponse::withOk('Relationship list',new GeneralCollection($this->repository->all('name')));
    }

    function show($relationship){
        $relationship=$this->repository->show($relationship);//pass the country
        return $relationship?
        ApiResponse::withOk('Relationship Found',new GeneralResource($relationship))
        : ApiResponse::withNotFound('Title Not Found');
    }

   function store(RelationshipRequest $relationshipRequest){
       try{
           $requestData=$relationshipRequest->all();

          $Title=$this->repository->store($requestData);
        return ApiResponse::withOk('Title created',new GeneralResource($Title->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(RelationshipRequest $relationshipRequest,$relationship){
       try{
        $relationship=$this->repository->update($relationshipRequest->all(),$relationship);

        return ApiResponse::withOk('Relationship updated',new GeneralResource($relationship));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }


}

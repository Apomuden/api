<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\SponsorshipTypeRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Exception;

class SponsorshipTypeController extends Controller
{
    protected $repository;

    public function __construct(SponsorshipType $sponsorshipType)
    {
        $this->repository= new RepositoryEloquent($sponsorshipType);
    }

    function index(){
        return ApiResponse::withOk('Sponsorship Type list',new GeneralCollection($this->repository->all('name')));
    }

    function show($sponsorshipType){
        $sponsorshipType=$this->repository->show($sponsorshipType);//pass the country
        return $sponsorshipType?
        ApiResponse::withOk('Sponsorship Type Found',new GeneralResource($sponsorshipType))
        : ApiResponse::withNotFound('Sponsorship Type Not Found');
    }

   function store(SponsorshipTypeRequest $sponsorshipTypeRequest){
       try{
           $requestData=$sponsorshipTypeRequest->all();
           $sponsorshipType=$this->repository->store($requestData);
           return ApiResponse::withOk('Sponsorship Type created',new GeneralResource($sponsorshipType->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }
   function update(SponsorshipTypeRequest $sponsorshipTypeRequest,$sponsorshipType){
       try{
        $sponsorshipType=$this->repository->update($sponsorshipTypeRequest->all(),$sponsorshipType);
        return ApiResponse::withOk('Sponsorship Type updated',new GeneralResource($sponsorshipType));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Sponsorship type deleted successfully');
    }
}

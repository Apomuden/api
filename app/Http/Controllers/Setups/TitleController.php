<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\TitleRequest;

use App\Http\Resources\TitleCollection;
use App\Http\Resources\TitleResource;
use App\Models\Title;

use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    protected $repository;

    public function __construct(title $title)
    {
        $this->repository= new RepositoryEloquent($title);
    }

    function index(){

        return ApiResponse::withOk('Title list',new TitleCollection($this->repository->all('name')));
    }

    function show($title){
        $title=$this->repository->show($title);//pass the country
        return $title?
        ApiResponse::withOk('Title Found',new TitleResource($title))
        : ApiResponse::withNotFound('Title Not Found');
    }

   function store(TitleRequest $titleRequest){
       try{
           $requestData=$titleRequest->all();

          $Title=$this->repository->store($requestData);
        return ApiResponse::withOk('Title created',new TitleResource($Title->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(TitleRequest $titleRequest,$title){
       try{
        $title=$this->repository->update($titleRequest->all(),$title);

        return ApiResponse::withOk('Title updated',new TitleResource($title));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Title deleted successfully');
    }
   function showByGender($gender){
    try{

       $titles= $this->repository->getModel()->whereRaw('? in (gender)',[$gender])->active()->orderBy('name')->get();

       return $titles?
       ApiResponse::withOk('Available Titles',new TitleCollection($titles))
       : ApiResponse::withNotFound('Titles Not Found');

    }
    catch(Exception $e){
     return ApiResponse::withException($e);
    }
   }


}

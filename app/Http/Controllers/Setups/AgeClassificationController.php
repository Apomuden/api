<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeClassificationRequest;
use App\Http\Resources\AgeClassificationCollection;
use App\Http\Resources\AgeClassificationResource;
use App\Models\AgeClassification;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class AgeClassificationController extends Controller
{
    protected $repository;

    public function __construct(AgeClassification $ageClassification)
    {
        $this->repository= new RepositoryEloquent($ageClassification);
    }

    public function index(){

        return ApiResponse::withOk('AgeClassification list',new AgeClassificationCollection($this->repository->all('name')));
    }

    public function show($AgeClassification){
        $AgeClassification=$this->repository->show($AgeClassification);//pass the country
        return $AgeClassification?
            ApiResponse::withOk('AgeClassification Found',new AgeClassificationResource($AgeClassification))
            : ApiResponse::withNotFound('AgeClassification Not Found');
    }

    public function store(AgeClassificationRequest $AgeClassificationRequest){
        try{
            $requestData=$AgeClassificationRequest->all();

            $AgeClassification=$this->repository->store($requestData);
            return ApiResponse::withOk('AgeClassification created',new AgeClassificationResource($AgeClassification->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(AgeClassificationRequest $AgeClassificationRequest,$id){
            $AgeClassification=$this->repository->update($AgeClassificationRequest->all(),$id);

            return ApiResponse::withOk('AgeClassification updated',new AgeClassificationResource($AgeClassification));
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('AgeClassification deleted successfully');
    }
}

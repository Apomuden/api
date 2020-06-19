<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\ObstetricQuestionOptionRequest;
use App\Http\Resources\Obstetrics\ObstetricQuestionOptionCollection;
use App\Http\Resources\Obstetrics\ObstetricQuestionOptionResource;
use App\Models\Obstetrics\ObstetricQuestionOption;
use App\Repositories\RepositoryEloquent;
use Exception;

class ObstetricQuestionOptionController extends Controller
{
    protected $repository;

    public function __construct(ObstetricQuestionOption $ObstetricQuestionOption)
    {
        $this->repository= new RepositoryEloquent($ObstetricQuestionOption);
    }

    public function index(){

        return ApiResponse::withOk('ObstetricQuestionOptions list',new ObstetricQuestionOptionCollection($this->repository->all('name')));
    }

    public function show($ObstetricQuestionOption){
        $ObstetricQuestionOption=$this->repository->show($ObstetricQuestionOption);
        return $ObstetricQuestionOption?
            ApiResponse::withOk('ObstetricQuestionOption Found',new ObstetricQuestionOptionResource($ObstetricQuestionOption))
            : ApiResponse::withNotFound('ObstetricQuestionOption Not Found');
    }

    public function store(ObstetricQuestionOptionRequest $ObstetricQuestionOptionRequest){
        try{
            $requestData=$ObstetricQuestionOptionRequest->all();
            $ObstetricQuestionOption=$this->repository->store($requestData);
            return ApiResponse::withOk('ObstetricQuestionOption created',new ObstetricQuestionOptionResource($ObstetricQuestionOption->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ObstetricQuestionOptionRequest $ObstetricQuestionOptionRequest,$ObstetricQuestionOption){
        try{
            $ObstetricQuestionOption=$this->repository->update($ObstetricQuestionOptionRequest->all(),$ObstetricQuestionOption);
            return ApiResponse::withOk('ObstetricQuestionOption updated',new ObstetricQuestionOptionResource($ObstetricQuestionOption));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('ObstetricQuestionOption deleted successfully');
    }
}

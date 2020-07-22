<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ProfessionRequest;
use App\Http\Resources\ProfessionCollection;
use App\Http\Resources\ProfessionResource;
use App\Models\Profession;
use App\Models\StaffCategory;
use App\Repositories\RepositoryEloquent;
use Exception;

class ProfessionController extends Controller
{
    protected $repository;

    public function __construct(Profession $profession)
    {
        $this->repository = new RepositoryEloquent($profession);
    }
    function index()
    {
        return ApiResponse::withOk('Profession list', new ProfessionCollection($this->repository->all('name')));
    }

    function show($profession)
    {
        $profession = $this->repository->show($profession);//pass the country
        return $profession ?
        ApiResponse::withOk('Profession Found', new ProfessionResource($profession))
        : ApiResponse::withNotFound('Profession Not Found');
    }

    function store(ProfessionRequest $professionRequest)
    {
        try {
            $requestData = $professionRequest->all();
            $profession = $this->repository->store($requestData);
            return ApiResponse::withOk('Profession created', new ProfessionResource($profession->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(ProfessionRequest $professionRequest, $profession)
    {
        try {
            $profession = $this->repository->update($professionRequest->all(), $profession);
            return ApiResponse::withOk('Profession updated', new ProfessionResource($profession));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Profession deleted successfully');
    }
    function showByCategory($staffcategory)
    {
        try {
            $this->repository->setModel(new StaffCategory());
            $professions = $this->repository->find($staffcategory)->professions()->active()->orderBy('name')->get();
            return ApiResponse::withOk('Available Professions', new ProfessionCollection($professions));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
}

<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\ObstetricHistoryRequest;
use App\Http\Resources\Obstetrics\ObstetricHistoryCollection;
use App\Http\Resources\Obstetrics\ObstetricHistoryResource;
use App\Models\Obstetrics\ObstetricHistory;
use App\Repositories\RepositoryEloquent;
use Exception;

class ObstetricHistoryController extends Controller
{
    protected $repository;

    public function __construct(ObstetricHistory $obstetricHistory)
    {
        $this->repository = new RepositoryEloquent($obstetricHistory);
    }

    public function index()
    {

        return ApiResponse::withOk('Obstetric Histories list', new ObstetricHistoryCollection($this->repository->all()));
    }

    public function show($obstetricHistory)
    {
        $obstetricHistory = $this->repository->show($obstetricHistory);
        return $obstetricHistory ?
            ApiResponse::withOk('Obstetric History Found', new ObstetricHistoryResource($obstetricHistory))
            : ApiResponse::withNotFound('Obstetric History Not Found');
    }

    public function store(ObstetricHistoryRequest $request)
    {
        try {
            $requestData = $request->all();
            $obstetricHistory = $this->repository->store($requestData);
            return ApiResponse::withOk('Obstetric History created', new ObstetricHistoryResource($obstetricHistory->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(ObstetricHistoryRequest $request, $obstetricHistory)
    {
        try {
            $obstetricHistory = $this->repository->update($request->all(), $obstetricHistory);
            return ApiResponse::withOk('Obstetric History updated', new ObstetricHistoryResource($obstetricHistory));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Obstetric History deleted successfully');
    }
}

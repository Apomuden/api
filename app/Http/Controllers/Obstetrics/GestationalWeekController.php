<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\GestationalWeekRequest;
use App\Http\Resources\Obstetrics\GestationalWeekCollection;
use App\Http\Resources\Obstetrics\GestationalWeekResource;
use App\Models\Obstetrics\GestationalWeek;
use App\Repositories\RepositoryEloquent;
use Exception;

class GestationalWeekController extends Controller
{
    protected $repository;

    public function __construct(GestationalWeek $week)
    {
        $this->repository = new RepositoryEloquent($week);
    }

    public function index()
    {

        return ApiResponse::withOk('GestationalWeeks list', new GestationalWeekCollection($this->repository->all('name')));
    }

    public function show($week)
    {
        $week = $this->repository->show($week);
        return $week ?
            ApiResponse::withOk('Gestational Week Found', new GestationalWeekResource($week))
            : ApiResponse::withNotFound('Gestational Week Not Found');
    }

    public function store(GestationalWeekRequest $request)
    {
        try {
            $requestData = $request->all();
            $week = $this->repository->store($requestData);
            return ApiResponse::withOk('Gestational Week created', new GestationalWeekResource($week->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(GestationalWeekRequest $request, $week)
    {
        try {
            $week = $this->repository->update($request->all(), $week);
            return ApiResponse::withOk('Gestational Week updated', new GestationalWeekResource($week));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Gestational Week deleted successfully');
    }
}

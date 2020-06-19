<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\ObsBirthPlaceRequest;
use App\Http\Resources\Obstetrics\ObsBirthPlaceCollection;
use App\Http\Resources\Obstetrics\ObsBirthPlaceResource;
use App\Models\Obstetrics\ObsBirthPlace;
use App\Repositories\RepositoryEloquent;
use Exception;

class ObsBirthPlaceController extends Controller
{
    protected $repository;

    public function __construct(ObsBirthPlace $ObsBirthPlace)
    {
        $this->repository = new RepositoryEloquent($ObsBirthPlace);
    }

    public function index()
    {

        return ApiResponse::withOk('ObsBirthPlaces list', new ObsBirthPlaceCollection($this->repository->all('name')));
    }

    public function show($ObsBirthPlace)
    {
        $ObsBirthPlace = $this->repository->show($ObsBirthPlace);
        return $ObsBirthPlace ?
            ApiResponse::withOk('ObsBirthPlace Found', new ObsBirthPlaceResource($ObsBirthPlace))
            : ApiResponse::withNotFound('ObsBirthPlace Not Found');
    }

    public function store(ObsBirthPlaceRequest $request)
    {
        try {
            $requestData = $request->all();
            $ObsBirthPlace = $this->repository->store($requestData);
            return ApiResponse::withOk('ObsBirthPlace created', new ObsBirthPlaceResource($ObsBirthPlace->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(ObsBirthPlaceRequest $request, $id)
    {
        try {
            $place = $this->repository->update($request->all(), $id);
            return ApiResponse::withOk('ObsBirthPlace updated', new ObsBirthPlaceResource($place));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('ObsBirthPlace deleted successfully');
    }
}

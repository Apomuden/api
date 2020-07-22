<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AccreditionRequest;
use App\Http\Resources\AccreditationCollection;
use App\Http\Resources\AccreditationResource;
use App\Models\Accreditation;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    protected $repository;

    public function __construct(Accreditation $accreditation)
    {
        $this->repository = new RepositoryEloquent($accreditation);
    }

    function index()
    {
        return ApiResponse::withOk('Accreditations list', new AccreditationCollection($this->repository->all()));
    }

    function show($accreditation)
    {
        $accreditation = $this->repository->show($accreditation);//pass the accreditation
        return $accreditation ?
        ApiResponse::withOk('Accreditation Found', new AccreditationResource($accreditation))
        : ApiResponse::withNotFound('Accreditation Not Found');
    }

    function store(AccreditionRequest $accreditionRequest)
    {
        try {
            $accreditation = $this->repository->store($accreditionRequest->all());
            return ApiResponse::withOk('Accreditation created', new AccreditationResource($accreditation->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(AccreditionRequest $accreditionRequest, $accreditation)
    {
        $accreditation = $this->repository->update($accreditionRequest->all(), $accreditation);
        return $accreditation ?
        ApiResponse::withOk('Accreditation Found', new AccreditationResource($accreditation))
        : ApiResponse::withNotFound('Accreditation Not Found');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Accreditation deleted successfully');
    }
}

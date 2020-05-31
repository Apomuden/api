<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ConsultationComponentRequest;
use App\Models\ConsultationComponent;
use App\Repositories\RepositoryEloquent;

class ConsultationComponentsController extends Controller
{
    protected $repository;

    public function __construct(ConsultationComponent $component)
    {
        $this->repository = new RepositoryEloquent($component);
    }

    public function index()
    {
        $records = $this->repository->all('value');
        return ApiResponse::withOk('Components list', $records);
    }

    public function store(ConsultationComponentRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Component created', $record);
    }

    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Component found', $record);
    }

    public function update(ConsultationComponentRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Component updated', $record);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Component deleted');
    }
}

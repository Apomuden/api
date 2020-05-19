<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ConsultationQuestionOptionRequest;
use App\Http\Resources\ConsultationQuestionOptionResource;
use App\Models\ConsultationQuestionOption;
use App\Repositories\RepositoryEloquent;

class ConsultationQuestionOptionsController extends Controller
{
    protected $repository;

    public function __construct(ConsultationQuestionOption $option)
    {
        $this->repository = new RepositoryEloquent($option);
    }

    public function index()
    {
        $records = $this->repository->all('value');
        return ApiResponse::withOk('Question options list', ConsultationQuestionOptionResource::collection($records));
    }

    public function store(ConsultationQuestionOptionRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Question option created', new ConsultationQuestionOptionResource($record));
    }

    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Question option found', new ConsultationQuestionOptionResource($record));
    }

    public function update(ConsultationQuestionOptionRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Question option updated', new ConsultationQuestionOptionResource($record));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Question option deleted');
    }
}

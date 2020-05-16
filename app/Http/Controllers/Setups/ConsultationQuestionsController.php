<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ConsultationQuestionRequest;
use App\Http\Resources\ConsultationQuestionResource;
use App\Models\ConsultationQuestion;
use App\Repositories\RepositoryEloquent;

class ConsultationQuestionsController extends Controller
{
    protected $repository;

    public function __construct(ConsultationQuestion $question)
    {
        $this->repository = new RepositoryEloquent($question);
    }

    public function index()
    {
        $records = $this->repository->all();
        return ApiResponse::withOk('Consultation questions', ConsultationQuestionResource::collection($records));
    }

    public function store(ConsultationQuestionRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Question Created', new ConsultationQuestionResource($record));
    }

    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Question found', new ConsultationQuestionResource($record));
    }

    public function update(ConsultationQuestionRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Question updated', new ConsultationQuestionResource($record));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Question deleted');
    }
}

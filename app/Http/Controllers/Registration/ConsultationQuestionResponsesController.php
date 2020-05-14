<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\ConsultationQuestionResponsesRequest;
use App\Http\Resources\Registrations\ConsultationQuestionResponseResource;
use App\Models\ConsultationQuestionResponse;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ConsultationQuestionResponsesController extends Controller
{
    protected $repository;

    public function __construct(ConsultationQuestionResponse $response)
    {
        $this->repository = new RepositoryEloquent($response);
    }

    public function index()
    {
        $records = $this->repository->all();

        return ApiResponse::withOk('Question response list', ConsultationQuestionResponseResource::collection($records));
    }

    public function store(ConsultationQuestionResponsesRequest $request)
    {
        DB::beginTransaction();
        $responses = $request->responses;
        $createdResponses = [];
        foreach ($responses as $response) {
            $response = (array)$response;
            $record = ConsultationQuestionResponse::updateOrCreate([
                'consultation_id' => $request->consultation_id,
                'consultation_question_id' => $response['consultation_question_id'],
            ], $request->except(['consultation_id', 'responses']) + $response);

            $createdResponses[] = $record->id;
        }
        DB::commit();
        $dbResponses = $this->repository->getModel()->whereIn('id', $createdResponses)->get();
        Artisan::call('cache:clear');
        return ApiResponse::withOk('Responses created', ConsultationQuestionResponseResource::collection($dbResponses));
    }

    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Response found', new ConsultationQuestionResponseResource($record));
    }

    public function update(ConsultationQuestionResponsesRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Response updated', new ConsultationQuestionResponseResource($record));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Response deleted');
    }
}

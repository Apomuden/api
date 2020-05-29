<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\ConsultationQuestionResponsesRequest;
use App\Http\Resources\Registrations\ConsultationGroupedQuestionResponseResource;
use App\Http\Resources\Registrations\ConsultationQuestionResponseResource;
use App\Models\Consultation;
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
        $records = $this->repository->all('id', 'ASC');
        return ApiResponse::withOk('Question response list',
            ConsultationQuestionResponseResource::collection($records));
    }

    // group responses by consultation
    public function showConsultGroupedResponses(Consultation $consultation)
    {
        $consultationRepo = new RepositoryEloquent($consultation);
        $consultations = $consultationRepo->all();
        // check if there are responses for these consultations
        $existingResponses = $this->repository->getModel()->whereIn('consultation_id', $consultations->modelKeys())->get();
        // throw 404 if no consultation has a response
        if (count($existingResponses) == 0) return ApiResponse::withNotFound('Nothing found');

        // filter only consultations that have responses for display
        $consultationsWithResponse = $consultations->filter(function ($r) use ($existingResponses) {
            return $existingResponses->contains('consultation_id', $r->id);
        });
        return ApiResponse::withOk('Grouped response list',
            ConsultationGroupedQuestionResponseResource::collection($consultationsWithResponse));
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

    // show responses belonging to this consultation with $id
    public function showConsultResponses($id, Consultation $consultation)
    {
        $consultationRepo = new RepositoryEloquent($consultation);
        $record = $consultationRepo->findOrFail($id);
        return ApiResponse::withOk('Response found', new ConsultationGroupedQuestionResponseResource($record));
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

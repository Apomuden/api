<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\MultipleObstetricQuestionResponseRequest;
use App\Http\Requests\Obstetrics\ObstetricQuestionResponseRequest;
use App\Http\Resources\Obstetrics\ObsConsultationGroupedQuestionResponseResource;
use App\Http\Resources\Obstetrics\ObstetricQuestionResponseCollection;
use App\Http\Resources\Obstetrics\ObstetricQuestionResponseResource;
use App\Http\Resources\Registrations\ConsultationGroupedQuestionResponseResource;
use App\Models\Consultation;
use App\Models\Obstetrics\ObstetricQuestionResponse;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ObstetricQuestionResponseController extends Controller
{
    protected $repository;

    public function __construct(ObstetricQuestionResponse $ObstetricQuestionResponse)
    {
        $this->repository = new RepositoryEloquent($ObstetricQuestionResponse);
    }

    public function index()
    {

        return ApiResponse::withOk('ObstetricQuestionResponses list', new ObstetricQuestionResponseCollection($this->repository->all('name')));
    }

    public function show($ObstetricQuestionResponse)
    {
        $ObstetricQuestionResponse = $this->repository->show($ObstetricQuestionResponse);
        return $ObstetricQuestionResponse ?
            ApiResponse::withOk('ObstetricQuestionResponse Found', new ObstetricQuestionResponseResource($ObstetricQuestionResponse))
            : ApiResponse::withNotFound('ObstetricQuestionResponse Not Found');
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

    // show responses belonging to this consultation with $id
    public function showConsultResponses($id, Consultation $consultation)
    {
        $consultationRepo = new RepositoryEloquent($consultation);
        $record = $consultationRepo->findOrFail($id);
        return ApiResponse::withOk('Responses found', new ObsConsultationGroupedQuestionResponseResource($record));
    }

    public function store(ObstetricQuestionResponseRequest $ObstetricQuestionResponseRequest)
    {
        try {
            $requestData = $ObstetricQuestionResponseRequest->all();
            $ObstetricQuestionResponse = $this->repository->store($requestData);
            return ApiResponse::withOk('ObstetricQuestionResponse created', new ObstetricQuestionResponseResource($ObstetricQuestionResponse->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function storeMultiple(MultipleObstetricQuestionResponseRequest $request)
    {
        DB::beginTransaction();
        $responses = $request->responses;
        $createdResponses = [];
        foreach ($responses as $response) {
            $response = (array)$response;
            $record = ObstetricQuestionResponse::updateOrCreate([
                'consultation_id' => $request->consultation_id,
                'obstetric_question_id' => $response['obstetric_question_id'],
            ], $request->except(['consultation_id', 'responses']) + $response);

            $createdResponses[] = $record->id;
        }
        DB::commit();
        $dbResponses = $this->repository->getModel()->whereIn('id', $createdResponses)->get();
        Artisan::call('cache:clear');
        return ApiResponse::withOk('Responses created', new ObstetricQuestionResponseCollection($dbResponses));
    }

    public function update(ObstetricQuestionResponseRequest $ObstetricQuestionResponseRequest, $ObstetricQuestionResponse)
    {
        try {
            $ObstetricQuestionResponse = $this->repository->update($ObstetricQuestionResponseRequest->all(), $ObstetricQuestionResponse);
            return ApiResponse::withOk('ObstetricQuestionResponse updated', new ObstetricQuestionResponseResource($ObstetricQuestionResponse));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('ObstetricQuestionResponse deleted successfully');
    }
}

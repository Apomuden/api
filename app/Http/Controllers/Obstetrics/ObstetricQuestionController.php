<?php

namespace App\Http\Controllers\Obstetrics;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Obstetrics\MultipleObstetricQuestionRequest;
use App\Http\Requests\Obstetrics\ObstetricQuestionRequest;
use App\Http\Resources\Obstetrics\ObstetricQuestionCollection;
use App\Http\Resources\Obstetrics\ObstetricQuestionResource;
use App\Models\Obstetrics\ObstetricQuestion;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ObstetricQuestionController extends Controller
{
    protected $repository;

    public function __construct(ObstetricQuestion $question)
    {
        $this->repository = new RepositoryEloquent($question);
    }

    public function index()
    {

        return ApiResponse::withOk('ObstetricQuestions list', new ObstetricQuestionCollection($this->repository->all('order')));
    }

    public function show($ObstetricQuestion)
    {
        $ObstetricQuestion = $this->repository->show($ObstetricQuestion);
        return $ObstetricQuestion ?
            ApiResponse::withOk('ObstetricQuestion Found', new ObstetricQuestionResource($ObstetricQuestion))
            : ApiResponse::withNotFound('ObstetricQuestion Not Found');
    }

    public function store(ObstetricQuestionRequest $ObstetricQuestionRequest)
    {
        try {
            $requestData = $ObstetricQuestionRequest->all();
            $ObstetricQuestion = $this->repository->store($requestData);
            return ApiResponse::withOk('ObstetricQuestion created', new ObstetricQuestionResource($ObstetricQuestion->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function storeMultiple(MultipleObstetricQuestionRequest $request)
    {
        DB::beginTransaction();
        $questions = $request->questions;
        $que_ids = [];
        foreach ($questions as $question) {
            $question = (array)$question;
            $record = ObstetricQuestion::updateOrCreate([
                'step' => $request->step,
                'question' => $question['question'],
            ], $request->except(['step', 'questions']) + $question);

            $que_ids[] = $record->id;
        }
        DB::commit();
        $records = $this->repository->getModel()->whereIn('id', $que_ids)->orderBy('order')->get();
        Artisan::call('cache:clear');
        return ApiResponse::withOk('Obstetric questions created', new ObstetricQuestionCollection($records));
    }

    public function update(ObstetricQuestionRequest $ObstetricQuestionRequest, $ObstetricQuestion)
    {
        try {
            $ObstetricQuestion = $this->repository->update($ObstetricQuestionRequest->all(), $ObstetricQuestion);
            return ApiResponse::withOk('ObstetricQuestion updated', new ObstetricQuestionResource($ObstetricQuestion));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('ObstetricQuestion deleted successfully');
    }
}

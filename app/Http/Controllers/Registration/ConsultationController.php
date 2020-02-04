<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\ConsultationRequest;
use App\Http\Resources\Registrations\ConsultationResource;
use App\Http\Resources\Registrations\ConsultationCollection;
use App\Models\Consultation;
use App\Repositories\RepositoryEloquent;
use Exception;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadeRoute;

class ConsultationController extends Controller
{
    protected $repository;
    protected $routeName;
    public function __construct(Consultation $consultation)
    {
        $this->repository = new RepositoryEloquent($consultation);
        $this->routeName = FacadeRoute::currentRouteName();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if ($this->routeName === 'consultationservicerequests.index') {
            return ApiResponse::withOk('Consultation Service Requests list', new ConsultationCollection($this->repository->showWhere(['status' => 'IN-QUEUE'])->get()));
        }
        return ApiResponse::withOk('Consultation Service list', new ConsultationCollection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConsultationRequest $request)
    {
        if(isset($request['sponsorship_type'])) {
            unset($request['sponsorship_type']);
        }
        $repo = new RepositoryEloquent(new Consultation);
        $hasAnUnservedRequest = $repo->findWhere(['patient_id'=>$request['patient_id'], 'status'=>'IN-QUEUE'])->count();
        //if($hasAnUnservedRequest) {
            //return ApiResponse::withValidationError(['patient_id'=>'Patient Already has a pending request']);
        //}
        $message = $this->routeName === 'consultationservicerequests.store' ? 'Consultation request created' : 'Consultation Service created';
        $response = $this->repository->store($request->all());

        return  ApiResponse::withOk( $message, new ConsultationResource($response->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $message = $this->routeName === 'consultationservicerequests.show' ? 'Consultation Service request' : 'Consultation Service';
        if ($this->routeName==='consultationservicerequests.show') {
            $consultation = $this->repository->showWhere(['id'=>$id,'status'=>'IN-QUEUE'])->first();
        }
        else {
            $consultation = $this->repository->show($id);
        }

        return $consultation ?
            ApiResponse::withOk($message.' Found', new ConsultationResource($consultation))
            : ApiResponse::withNotFound($message.' Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ConsultationRequest $request, $consultation)
    {
        try{

            $consultation = $this->repository->update($request->all(), $consultation);

            return ApiResponse::withOk('Consultation Service updated', new ConsultationResource($consultation));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Consultation Service deleted successfully');
    }

}

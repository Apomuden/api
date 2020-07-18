<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\Notify;
use App\Http\Requests\Registrations\ConsultationRequest;
use App\Http\Resources\Registrations\ConsultationResource;
use App\Http\Resources\Registrations\ConsultationCollection;
use App\Models\Clinic;
use App\Models\Consultation;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
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
        $searchParams = \request()->query();
        $statusParam = $searchParams['status']??null;
        unset($searchParams);
        if ($this->routeName === 'consultationservicerequests.index' && !$statusParam) {
            //DB::enableQueryLog();
            $this->repository->setModel(Consultation::where('status', 'IN-QUEUE'));
            $records= $this->repository->all('attendance_date', 'DESC');
            //return [DB::getQueryLog()];
            return ApiResponse::withOk('Consultation Service Requests list', new ConsultationCollection($records));
        }
        return ApiResponse::withOk('Consultation Service list', new ConsultationCollection($this->repository->all('attendance_date','DESC')));
    }

    public function getInitialQueue($consultant_id){
       $initialQueue= $this->repository->getModel()
       ->where('consultant_id',$consultant_id)
       ->where('status', 'IN-QUEUE')
       ->get();
      return [
            'message' =>ConsultationResource::collection($initialQueue),
            'event' => 'new-message',
            'subscriber_id' => $consultant_id
        ];
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
            if (!isset($request['sponsorship_type_id'])) {
                $sponsorshipType = (new RepositoryEloquent(new SponsorshipType))->findWhere(['name'=>$request['sponsorship_type']])
                ->orWhere(['name'=>ucfirst($request['sponsorship_type'])])
                ->orWhere(['name'=>ucwords($request['sponsorship_type'])])
                ->orWhere(['name'=>strtolower($request['sponsorship_type'])])
                ->orWhere(['name'=>strtoupper($request['sponsorship_type'])])->first();
                $sponsorshipType = $sponsorshipType?$sponsorshipType->id:null;
                if ($sponsorshipType) {
                    $request['sponsorship_type_id'] = $sponsorshipType;
                }
                unset($sponsorshipType);
            }
            if (strtolower(trim($request['sponsorship_type']))=='patient') {
                $request['billing_sponsor_id'] = null;
                $request['patient_sponsor_id'] = null;
            }
            unset($request['sponsorship_type']);
        }
        if (isset($request['clinic_id'])) {
            $clinic_type_id = ((new RepositoryEloquent(new Clinic))->find($request['clinic_id'])->first()->clinic_type_id)??null;
            if ($clinic_type_id)
                $request['clinic_type_id'] = $clinic_type_id;

            unset($clinic_type_id);
        }

        $hasAPendingRequest = Consultation::where(['patient_id'=>$request['patient_id'], 'status'=>'IN-QUEUE'])->whereDate(DB::raw('DATE(attendance_date)'),Carbon::parse($request['attendance_date'])->format('Y-m-d') ?? today()->format('Y-m-d'))->count();

        if($hasAPendingRequest)
            return ApiResponse::withValidationError(['patient_id'=>'Patient Already has a pending request with the same attendance date']);

        $message = $this->routeName === 'consultationservicerequests.store' ? 'Consultation request created' : 'Consultation Service created';
        $response = $this->repository->store($request->all());
        return  ApiResponse::withOk($message, new ConsultationResource($response->refresh()));
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
        $consultation = $this->repository->show($id);
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
            $consultation = $this->repository->update($request->all(), $consultation);

            return ApiResponse::withOk('Consultation Service updated', new ConsultationResource($consultation));
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Consultation Service deleted successfully');
    }

}

<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\AppointmentRequest;
use App\Http\Resources\Registrations\AppointmentResource;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $repository;
    public function __construct(Appointment $appointment)
    {
        $this->repository = new RepositoryEloquent($appointment);
    }
    public function index()
    {

        return ApiResponse::withOk('Appointments list', AppointmentResource::collection($this->repository->all('id')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        $request['entered_by'] = Auth::id();
        $sponsor = $this->repository->store($request->all());
        if (isset($request['clinic_id'])) {
            $clinic_type_id = ((new RepositoryEloquent(new Clinic()))->find($request['clinic_id'])->first()->clinic_type_id) ?? null;
            if ($clinic_type_id) {
                $request['clinic_type_id'] = $clinic_type_id;
            }
            unset($clinic_type_id);
        }

        return ApiResponse::withOk('Appointment created', new AppointmentResource($sponsor->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($appointment)
    {
        $appointment = $this->repository->find($appointment);
        return ApiResponse::withOk('Appointment found', new AppointmentResource($appointment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, $appointment)
    {
        $appointment = $this->repository->update($request->all(), $appointment);
        return ApiResponse::withOk('Appointment updated', new AppointmentResource($appointment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($appointment)
    {
        $appointment = $this->repository->delete($appointment);
        return ApiResponse::withOk('Appointment deleted successfully');
    }
}

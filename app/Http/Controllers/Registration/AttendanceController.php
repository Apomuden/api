<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\AttendanceRequest;
use App\Http\Resources\Clinic\AttendanceResource;
use App\Models\Attendance;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $repository;
    public function __construct(Attendance $clinic)
    {
        $this->repository = new RepositoryEloquent($clinic);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::withOk('Attendance list', AttendanceResource::collection($this->repository->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AttendanceRequest $request)
    {
        $response = $this->repository->store($request->all());

        return  ApiResponse::withOk('Attendance created', new AttendanceResource($response));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Attendance = $this->repository->show($id);
        return $Attendance ?
            ApiResponse::withOk('Attendance Found', new AttendanceResource($id))
            : ApiResponse::withNotFound('Attendance Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AttendanceRequest $request, $id)
    {
        try {
            $Attendance = $this->repository->update($request->all(), $id);

            return ApiResponse::withOk('Attendance updated', new AttendanceResource($Attendance));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Attendance deleted successfully');
    }

}

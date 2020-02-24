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
    protected $repository,$withCallback,$searchParams = [];
    public function __construct(Attendance $clinic)
    {
        $this->searchParams = \request()->query();

        $folder_no = $this->searchParams['folder_no'] ?? null;
        $rack_no = $this->searchParams['rack_no'] ?? null;
        $folder_type = $this->searchParams['folder_type'] ?? null;

        //Folder Postfix of patient
        $postfix = $folder_no ? substr($folder_no, -1) : null;

        unset($this->searchParams['folder_no'],
        $this->searchParams['rack_no'],
        $this->searchParams['folder_type']);

        $folderSearch = [];
        if ($folder_no)
            $folderSearch['folder_no'] = '=' . $folder_no;

        if ($postfix && !is_numeric(trim($postfix))) {
            //$this->searchParams['postfix'] = '=' . trim($postfix);
            $folderSearch['folder_no'] = rtrim($folderSearch['folder_no'], $postfix);
        }

        if ($rack_no)
            $folderSearch['rack_no'] = $rack_no;

        if ($folder_type)
            $folderSearch['folder_type'] = $folder_type;

        if ($folderSearch)
            $this->withCallback = function ($query) use ($folderSearch) {
                $query->whereHas(['folders',function($query2) use($folderSearch){
                   $query2->findBy($folderSearch);
                }]);
            };
        if ($this->withCallback)
            $with['patient'] = $this->withCallback;

        $this->repository = new RepositoryEloquent($clinic,true,$with);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //DB::enableQueryLog();
        $this->repository->useFindBy = false;

        //Enforce folder search only when folder params are specified
        if ($this->withCallback)
            $this->repository->setModel(Attendance::findBy($this->searchParams)->whereHas('patient', $this->withCallback));
        else
            $this->repository->setModel(Attendance::findBy($this->searchParams));

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

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
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    protected $repository,$withCallback,$searchParams = [];
    public function __construct(Attendance $clinic)
    {
        $this->searchParams = \request()->query();



        $this->repository = new RepositoryEloquent($clinic);
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
    public function byFolderNo(Request $request){
        $searchParams = \request()->query();

        $folder_no = $searchParams['folder_no'] ?? null;


        //Folder Postfix of patient
        $postfix = $folder_no ? substr($folder_no, -1) : null;

        unset($searchParams['folder_no'],
        $searchParams['rack_no'],
        $searchParams['folder_type']);



        if ($folder_no)
            $folderSearch['folder_no'] = '=' . $folder_no;



        if ($postfix && !is_numeric(trim($postfix))) {
            //$searchParams['postfix'] = '=' . trim($postfix);
            $folderSearch['folder_no'] = rtrim($folderSearch['folder_no'], $postfix);
        }
        $withCallback = function ($query) use ($folderSearch) {
            $query->findBy($folderSearch);
        };
        //DB::enableQueryLog();
         $this->repository->setModel(Attendance::findBy($searchParams)->whereHas('patient', function ($query) use ($withCallback,$folderSearch,$postfix) {
            if($postfix)
            $query->where('postfix',$postfix)->whereHas('folders', $withCallback);
            else
            $query->whereHas('folders', $withCallback);
        }));

        $records= $this->repository->getModel()->get();

        //return [DB::getQueryLog()];
        return ApiResponse::withOk('Found Attendances', AttendanceResource::collection($records));
    }
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

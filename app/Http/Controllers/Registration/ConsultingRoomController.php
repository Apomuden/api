<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\ConsultingRoomRequest;
use App\Http\Resources\Registrations\ConsultationResource;
use App\Http\Resources\Registrations\ConsultingRoomResource;
use App\Models\ConsultingRoom;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ConsultingRoomController extends Controller
{
    protected $repository;
    public function __construct(ConsultingRoom $consultationRoom)
    {
        $this->repository = new RepositoryEloquent($consultationRoom);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return ApiResponse::withOk('Consulting rooms list',ConsultingRoomResource::collection($this->repository->all('description')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultingRoomRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Consulting room created',new ConsultationResource($record->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->show($id);
        return ApiResponse::withOk('Consulting room found', new ConsultationResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultingRoomRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Consulting room updated', new ConsultationResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Consulting Room deleted');
    }
}

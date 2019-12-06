<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Repositories\HospitalEloquent;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    protected $repository;

    public function __construct(Hospital $hospital)
    {
        $this->repository= new HospitalEloquent($hospital);
    }

    public function index()
    {
        //
    }



    public function store(Request $request)
    {
        //
    }


    public function show()
    {
       return  ApiResponse::withOk('Hospital Found',new HospitalResource($this->repository->first()));
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}

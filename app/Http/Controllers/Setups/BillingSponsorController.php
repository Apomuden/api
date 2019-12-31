<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Models\BillingSponsor;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class BillingSponsorController extends Controller
{
    protected $repository;

    public function __construct(BillingSponsor $billingSponsor)
    {
        $this->repository=new RepositoryEloquent($billingSponsor);
    }
    public function index()
    {
        $this->repository->all('name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

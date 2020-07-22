<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\BillingSponsor;
use App\Models\Company;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    protected $repository;

    public function __construct(Company $company)
    {
        $this->repository = new RepositoryEloquent($company);
    }

    function index()
    {
        return ApiResponse::withOk('Company list', new CompanyCollection($this->repository->all('name')));
    }

    /* function search(){
        $params=\request()->query();
        if($params)
        $companies=$this->repository->getModel()->findBy($params)->get();
        else
        $companies=$this->repository->all('name');

        return ApiResponse::withOk('Companies found',new CompanyCollection($companies));
    } */

    function show($company)
    {
        $company = $this->repository->show($company);//pass the country
        return $company ?
        ApiResponse::withOk('Company Found', new CompanyResource($company))
        : ApiResponse::withNotFound('Company Not Found');
    }

    function store(CompanyRequest $companyRequest)
    {
        try {
            $requestData = $companyRequest->all();
            $sponsorship_type_id = $requestData['sponsorship_type_id'] ?? null;

            unset($requestData['sponsorship_type_id']);

            DB::beginTransaction();
            $company = $this->repository->store($requestData);

            if ($sponsorship_type_id && $company) {
                $this->repository->setModel(new BillingSponsor());
                $this->repository->store(['name' => $company->name,'sponsorship_type_id' => $sponsorship_type_id,'company_id' => $company->id]);
            }
            DB::commit();
            return ApiResponse::withOk('Company created', new CompanyResource($company->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(CompanyRequest $companyRequest, $company)
    {
        try {
            $company = $this->repository->update($companyRequest->all(), $company);

            return ApiResponse::withOk('Company updated', new CompanyResource($company));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Company deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\ProfilePaginatedCollection;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterationController extends Controller
{
   protected $repository;
   public function __construct(User $user)
   {
      $this->repository=new RepositoryEloquent($user);
   }
   function index(){
        $this->repository->useActiveTrait=false;
        $users=$this->repository->paginate(10,'username');

        return ApiResponse::withPaginate(new ProfilePaginatedCollection($users,'List of users'));
   }
}

<?php

namespace App\Http\Controllers\Summaries;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\Summaries\StaffCategoryResource;
use App\Models\User;
use Illuminate\Http\Request;

class StaffCategoryController extends Controller
{
    public function index()
    {
        $staffCategories = User::getCategorySummary();
        return ApiResponse::withOk('Staff Category Summaries', StaffCategoryResource::collection($staffCategories));
    }
}

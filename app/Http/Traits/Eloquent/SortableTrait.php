<?php
namespace App\Http\Traits\Eloquent;

use App\Http\Helpers\ApiRequest;

trait SortableTrait
{
    function scopeSortBy($query,$sortBy=null,$order='ASC'){
        //Get the sort from the route params
        $sortBy=\request()->input('sortBy')??$sortBy;
        $order=\request()->input('order')??$order;

        $sortBy=ApiRequest::sanitize_string($sortBy)??null;
        $order=ApiRequest::sanitize_string($order)??null;

       return $sortBy? $query->orderBy($sortBy,$order):$query;
    }
}

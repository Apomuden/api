<?php
namespace App\Http\Traits;


trait SortableTrait
{
    function scopeSortBy($query,$sortBy=null,$order='ASC'){
        //Get the sort from the route params
        $sortBy=\request()->input('sortBy')??$sortBy;
        $order=\request()->input('order')??$order;

       return $sortBy? $query->orderBy($sortBy,$order):$query;
    }
}

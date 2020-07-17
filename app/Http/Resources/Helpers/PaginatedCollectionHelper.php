<?php

namespace App\Http\Resources\Helpers;

use App\Http\Resources\Registrations\PatientResource;
use App\Http\Traits\Resources\PaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollectionHelper extends ResourceCollection
{
    use PaginationTrait;

    //pagination and resource must be defined to allow pagination
    public $pagination, $resource, $isPaginated, $message;

    public function __construct($resource,  $message=null, $isPaginated=false)
    {
        $this->isPaginated = $isPaginated;
        $this->resource = $resource;
        $this->message = $message;
        if ($this->isPaginated) {
            $this->paginateLinks();
            //$resource = $resource->getCollection();
        }

        parent::__construct($resource);
    }

    public function toArray($request, $resource=null)
    {
        $dataCount = count($this->collection);
        $data=[
            'errorCode'=>'000',
            'taggedAs'=>$this->message?$this->message:'No records found',
            'dataCount'=>$dataCount,
            'data'=>$resource,
        ];
        if ($this->isPaginated === true) {
            if ($dataCount && $this->pagination && $this->isPaginated) {
                $data['pagination'] = $this->pagination;
            }
        }
        else {
            return $data;
        }

        return $data;
    }
}

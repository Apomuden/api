<?php

namespace App\Http\Resources;

use App\Http\Traits\Resources\PaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DiseasePaginatedCollection extends ResourceCollection
{
   use PaginationTrait;

   //pagination and resource must be defined to allow pagination
    public $pagination,$message,$resource;

    public function __construct($resource,$message)
    {
        $this->resource=$resource;
        $this->message=$message;
        $this->paginateLinks();
        //$resource = $resource->getCollection();

        parent::__construct($resource);
    }
    public function toArray($request)
    {
        $data= [
            'errorCode'=>'000',
            'taggedAs'=>count($this->collection)?$this->message:'No records found',
            'dataCount'=>count($this->collection),
            'data'=>DiseaseResource::collection($this->collection),
        ];

        if($data['dataCount'] && $this->pagination)
        $data['pagination']=$this->pagination;

        return $data;
    }

}

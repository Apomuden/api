<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $pagination,$message;

    public function __construct($resource,$message)
    {
        $newResource=Json_decode(json_encode($resource));
        $this->pagination = [
            'current_page' =>$resource->currentPage(),
            'current_page_url' =>$newResource->path.'?page='.$resource->currentPage(),
            'first_page_url'=>$newResource->first_page_url,
            'next_page_url' =>$newResource->next_page_url,
            'prev_page_url' =>$newResource->prev_page_url,
            'last_page_url' =>$newResource->last_page_url,
            'total_pages' => $resource->lastPage()
        ];
        $this->message=$message;

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
    public function toArray($request)
    {
        return  [
            'errorCode'=>'000',
            'taggedAs'=>count($this->collection)?$this->message:'No records found',
            'dataCount'=>count($this->collection),
            'data'=>PermissionResource::collection($this->collection),
            'pagination' => $this->pagination
        ];

    }

}

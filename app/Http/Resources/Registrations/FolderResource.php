<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\Country;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class FolderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'folder_no'=>$this->folder_no,
            'folder_type'=>$this->folder_type,
            'status'=>$this->status
        ];
    }
}

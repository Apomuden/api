<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id)){
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'sort_code'=>$this->sort_code,
                'bank_name'=>$this->bank->name??null,
                'bank_id'=>$this->bank->id??null,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}

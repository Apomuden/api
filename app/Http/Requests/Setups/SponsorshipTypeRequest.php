<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class SponsorshipTypeRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('sponsorshiptype')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:sponsorship_types'.($id?','.$id:''),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}

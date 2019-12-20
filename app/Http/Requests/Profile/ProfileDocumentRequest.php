<?php

namespace App\Http\Requests\Profile;
use App\Http\Requests\ApiFormRequest;

class ProfileDocumentRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('profiledocument')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:user_documents,user_id'.(isset($this->id)?','.$this->id:''),
            'user_id'=>'bail|'.($id?'sometimes':'required').'|exists:users,id',
            'file'=>'bail|'.($id?'sometimes':'required').'|file64:pdf',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}

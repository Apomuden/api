<?php
//This is Request is for the current logged in user
namespace App\Http\Requests\Profile;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){

       if(Request::route()->getName()=='profiles.store')
         $id=null;
       else
        $id = $this->route('profile')??Auth::guard('api')->user();

        return [
            'username' => 'bail|'.($id?'sometimes':'required').'|string|unique:users,username'.($id?','.$id:''),
            'id_no' => 'bail|sometimes|nullable|string|unique:users,id_no'.($id?','.$id:''),
            'active_cell' => 'bail|'.($id?'sometimes':'required').'|min:10|unique:users,active_cell'.($id?','.$id:''),
            'email'=>'bail|sometimes|nullable|email|unique:users,email'.($id?','.$id:''),
            'ssnit_no'=>'bail|sometimes|nullable|unique:users,ssnit_no'.($id?','.$id:''),
            'tin'=>'bail|sometimes|nullable|unique:users,tin'.($id?','.$id:''),
            'title_id'=>'bail|sometimes|integer|exists:titles,id',
            'surname'=>'bail|'.($id?'sometimes':'required').'|string',
            'middlename'=>'bail|sometimes|nullable|string',
            'firstname'=>'bail|'.($id?'sometimes':'required').'|string',
            'dob'=>'bail|'.($id?'sometimes':'required').'|date',
            'gender'=>'bail|'.($id?'sometimes':'required').'|in:MALE,FEMALE,BIGENDER',
            'id_type_id'=>'bail|sometimes|nullable|exists:id_types,id',
            'role_id'=>'bail|'.($id?'sometimes':'required').'|exists:roles,id',
            'religion_id'=>'bail|sometimes|nullable|exists:religions,id',
            'educational_level_id'=>'bail|sometimes|nullable|exists:educational_levels,id',
            'residence'=>'bail|'.($id?'sometimes':'required').'',
            'origin_country_id '=>'bail|sometimes|nullable|exists:countries,id',
            'origin_region_id '=>'bail|sometimes|nullable|exists:regions,id',
            'hometown_id '=>'bail|sometimes|nullable|exists:regions,id',
            'marital '=>'bail|sometimes|nullable|in:SINGLE,MARRIED,DIVORCED,WIDOW,WIDOWER,OTHER',
            'alternate_cell'=>'bail|sometimes|nullable|integer|min:9',
            'emerg_name'=>'bail|sometimes|nullable|string',
            'emerg_phone1'=>'bail|sometimes|nullable|numeric|min:10',
            'emerg_phone2'=>'bail|sometimes|nullable|numeric|min:10',
            'emerg_relation_id'=>'bail|sometimes|nullable|exists:relationships,id',
            'department_id'=>'bail|sometimes|nullable|exists:departments,id',
            'staff_type_id'=>'bail|sometimes|nullable|exists:staff_types,id',
            'expires'=>'bail|sometimes|boolean',
            'expiry_date'=>'bail|sometimes|nullable|date',
            'profession_id'=>'bail|sometimes|nullable|exists:professions,id',
            'staff_specialty_id'=>'bail|sometimes|nullable|exists:staff_specialties,id',
            'appointment_date'=>'bail|sometimes|nullable|date',
            'basic'=>'bail|sometimes|numeric',
            'bank_id'=>'bail|sometimes|nullable|exists:banks,id',
            'bank_branch_id'=>'bail|sometimes|nullable|exists:bank_branches,id',
            'bank_acct_no'=>'bail|sometimes|nullable|numeeric',
            'staff_category_id'=>'bail|sometimes|nullable|exists:staff_categories,id',
            'prof_body'=>'bail|sometimes|nullable|string',
            'prof_reg_no'=>'bail|sometimes|nullable|string',
            'prof_expiry_date'=>'bail|sometimes|nullable|date',
            'signature'=>'bail|sometimes|nullable|file64:jpeg,jpg,png',
            'photo'=>'bail|sometimes|nullable|file64:jpeg,jpg,png',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}

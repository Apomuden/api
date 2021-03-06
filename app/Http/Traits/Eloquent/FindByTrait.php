<?php
namespace App\Http\Traits;

use App\Http\Helpers\ApiRequest;
use Illuminate\Support\Facades\Log;
use stdClass;

trait FindByTrait{

    private function getComparator($value){
        $paramObj=new stdClass;
         if(ApiRequest::startsWith(trim($value),'='))
         {
             $paramObj->comparator='=';
             $paramObj->value=str_replace('=','',trim($value));
         }
         else if(ApiRequest::startsWith(trim($value),'!'))
         {
            $paramObj->comparator='!=';
            $paramObj->value=str_replace('!','',trim($value));
         }
         else
         {
            $paramObj->comparator='like';
            $paramObj->value="{$value}%";
         }

         return $paramObj;

    }
    public function scopeFindBy($query,array $params){

        $dateFrom=$params['dateFrom']??null;
        $dateTo=$params['dateTo']??null;

        unset($params['dateFrom']);
        unset($params['dateTo']);
        unset($params['page']);

        if($dateFrom)
        $query=$query->whereDate('created_at', '>=', date('Y-m-d',strtotime($dateFrom)));

        if($dateTo)
        $query=$query->whereDate('created_at', '<=', date('Y-m-d',strtotime($dateTo)));

        unset($params['sortBy'],$params['order']);

        //Log::debug('Params Type',$params);

        if($params){
            $first_key=key(isset($params[0])?$params[0]:$params);
            $first_value=isset($params[0])?$params[0][$first_key]:$params[$first_key];

            $first_key=ApiRequest::sanitize_string($first_key)??null;
            $first_value=ApiRequest::sanitize_string($first_value)??null;

            $paramObj=$this->getComparator($first_value);

            $query=$query->Where($first_key,$paramObj->comparator,$paramObj->value);
            unset($params[0][$first_key],$params[$first_key]);
        }

        foreach($params as $key=>$value){
            $key=ApiRequest::sanitize_string($key)??null;
            $value=ApiRequest::sanitize_string($value)??null;

            $paramObj=$this->getComparator($value);

            $query=$query->orWhere($key,$paramObj->comparator,$paramObj->value);
        }
        return $query;
    }
}

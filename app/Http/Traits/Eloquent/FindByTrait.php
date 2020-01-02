<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait FindByTrait{
    public function scopeFindBy($query,array $params){
        $dateFrom=$params['dateFrom']??null;
        $dateTo=$params['dateTo']??null;

        unset($params['dateFrom']);
        unset($params['dateTo']);

        if($dateFrom)
        $query=$query->whereDate('created_at', '=>', date(strtotime($dateFrom)));

        if($dateTo)
        $query=$query->whereDate('created_at', '<=', date(strtotime($dateTo)));

        unset($params['sortBy'],$params['order']);

        //Log::debug('Params Type',[key($params)]);

        if($params){
            $first_key=key(isset($params[0])?$params[0]:$params);
            $first_value=isset($params[0])?$params[0][$first_key]:$params[$first_key];
            $query=$query->Where($first_key,'like',"{$first_value}%");
            unset($params[0][$first_key],$params[$first_key]);
        }

        foreach($params as $key=>$value){
            $query=$query->orWhere($key,'like',"{$value}%");
        }
        return $query;
    }
}

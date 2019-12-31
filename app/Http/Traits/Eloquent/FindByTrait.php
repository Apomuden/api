<?php
namespace App\Http\Traits;
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

        foreach($params as $key=>$value){
            $query=$query->orWhere($key,'like',"{$value}%");
        }
        return $query;
    }
}

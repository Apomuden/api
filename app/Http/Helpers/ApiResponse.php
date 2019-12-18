<?php
namespace App\Http\Helpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use  Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiResponse{

    static function withJson($errorCode,$message,$data=NULL,$http_response_code=200,$http_response_header=[]){
      return response()->json(['errorCode'=>$errorCode,'taggedAs'=>$message,'data'=>$data],$http_response_code,$http_response_header);
    }

    static function withValidationError($data=NULL,$http_response_header=[]){
        return response()->json(['errorCode'=>'001','taggedAs'=>'Validation error','data'=>(is_object($data)?$data->all():$data)],HttpResponse::HTTP_BAD_REQUEST,$http_response_header);
      }

    static function withOk($message,$data=NULL,$http_response_header=[]){
        $response=['errorCode'=>'000','taggedAs'=>$message,];

        if(is_countable($data)){
            $response['dataCount']=count($data);
            if(count($data)==0)
            $response['taggedAs']='No records found';
        }

        $response['data']=$data['data']??$data;
        return response()->json($response,HttpResponse::HTTP_OK,$http_response_header);
    }

    static function withPaginate($data=NULL,$http_response_header=[]){

        return response()->json($data,HttpResponse::HTTP_OK,$http_response_header);
    }


    static function withNotFound($message=null,$http_response_header=[]){
        return response()->json(['errorCode'=>'002','taggedAs'=>'Resource not found','data'=>$message],HttpResponse::HTTP_NOT_FOUND,$http_response_header);
    }

    static function withException(\Exception $e,$data=NULL,$http_response_header=[]){
        if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
        return self::withNotFound();
        else{
            Log::error($e->getMessage());
            return response()->json(['errorCode'=>'003','taggedAs'=>'Error','data'=>$data],HttpResponse::HTTP_INTERNAL_SERVER_ERROR,$http_response_header);
        }

    }

    static function withNotOk($message,$data=NULL,$http_response_header=[]){
        $response=['errorCode'=>'004','taggedAs'=>$message,];

        if(is_countable($data)){
            $response['dataCount']=count($data);
            if(count($data)==0)
            $response['taggedAs']='No records found';
        }

        $response['data']=$data;
        return response()->json($response,HttpResponse::HTTP_NOT_FOUND,$http_response_header);
    }
    static function withNotAuthorized($data=NULL,$http_response_header=[]){
        return response()->json(['errorCode'=>'004','taggedAs'=>'Unauthorized','data'=>null],HttpResponse::HTTP_UNAUTHORIZED,$http_response_header);
      }
}

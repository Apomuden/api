<?php
namespace App\Http\Helpers;
use Illuminate\Http\Response;
use  Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiResponse{

    static function withJson($errorCode,$message,$data=NULL,$http_response_code=200,$http_response_header=[]){
      return response()->json(['errorCode'=>$errorCode,'response'=>$message,'data'=>$data],$http_response_code,$http_response_header);
    }

    static function withValidationError($data=NULL,$http_response_header=[]){
        return response()->json(['errorCode'=>'001','response'=>'Validation error','data'=>(is_object($data)?$data->all():$data)],HttpResponse::HTTP_BAD_REQUEST,$http_response_header);
      }

    static function withOk($message,$data=NULL,$http_response_header=[]){
        $response=['errorCode'=>'000','response'=>$message,];

        if(is_countable($data)){
            $response['dataCount']=count($data);
            if(count($data)==0)
            $response['response']='No records found';
        }

        $response['data']=$data;
        return response()->json($response,HttpResponse::HTTP_OK,$http_response_header);
    }

    static function withNotFound($message=null,$http_response_header=[]){
        return response()->json(['errorCode'=>'002','response'=>'Resource not found','data'=>$message],HttpResponse::HTTP_NOT_FOUND,$http_response_header);
    }

    static function withException(\Exception $e,$data=NULL,$http_response_header=[]){
        \Log::error($e->getMessage());
        return response()->json(['errorCode'=>'003','response'=>'Error','data'=>$data],HttpResponse::HTTP_INTERNAL_SERVER_ERROR,$http_response_header);
    }

    static function withNotOk($message,$data=NULL,$http_response_header=[]){
        $response=['errorCode'=>'004','response'=>$message,];

        if(is_countable($data)){
            $response['dataCount']=count($data);
            if(count($data)==0)
            $response['response']='No records found';
        }

        $response['data']=$data;
        return response()->json($response,HttpResponse::HTTP_NOT_FOUND,$http_response_header);
    }
}

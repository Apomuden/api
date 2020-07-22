<?php

namespace App\Exceptions;

use App\Http\Helpers\ApiResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use  Symfony\Component\HttpFoundation\Response as HttpResponse;

class Handler extends ExceptionHandler
{
    protected $errorCode = '500';
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

       /*if ($exception instanceof UnauthorizedException) {

            $preException = $exception->getPrevious();
            if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return ApiResponse::withNotAuthorized('TOKEN_EXPIRED');
            } else if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ApiResponse::withNotAuthorized('TOKEN_EXPIRED');

            } else if ($preException instanceof
                     \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                        return ApiResponse::withNotAuthorized('TOKEN_BLACKLISTED');
           }
           if ($exception->getMessage() === 'Token not provided') {
                 return ApiResponse::withNotAuthorized('TOKEN_NOT_PROVIDED');

           }
        }

        else if($this->isHttpException($exception))
        {

            if ($exception->getCode() == 404) {
                return ApiResponse::withNotFound('RESOURCE_NOT_FOUND');
            }
            else
               return ApiResponse::withNotAuthorized($exception->getMessage());
        }
        else if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
             return ApiResponse::withNotFound('RESOURCE_NOT_FOUND');
        else if($exception instanceof \Symfony\Component\Debug\Exception\FatalThrowableError)
            return ApiResponse::withJson(404,'EXECUTION_ERROR',NULL,HttpResponse::HTTP_EXPECTATION_FAILED);

       else if($exception instanceof \BadMethodCallException)
        return ApiResponse::withJson($this->errorCode,'RESOURCE_CALL_ERROR',NULL,HttpResponse::HTTP_BAD_REQUEST);
       else
       return ApiResponse::withJson($this->errorCode,trim($exception->getMessage(),'.'),NULL,HttpResponse::HTTP_UNAUTHORIZED);

       if($exception instanceof QueryException){
        $searchParams=\request()->query();

        unset($searchParams['sortBy']);
        unset($searchParams['order']);
        if($searchParams){
            $messageArray=explode('(',$exception->getMessage());
            return ApiResponse::withJson($this->errorCode,'RESOURCE_CALL_ERROR',$messageArray[0],HttpResponse::HTTP_BAD_REQUEST);
        }
       }*/
        return parent::render($request, $exception);
    }
}

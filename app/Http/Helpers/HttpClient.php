<?php
namespace App\Http\Helpers;

use Exception;
class HttpClient{
    static function post($end_point,$payload,$headers=[]){

        $payload=\json_encode($payload);
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $end_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_SSL_VERIFYHOST=>false,
            CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER =>array_merge(array(

                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: ".strlen($payload),
                "Accept: application/json",
                "Content-Type: application/json",
                "cache-control: no-cache",
            ),$headers) ,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            //\Log::notice('Payload::'.$payload);

            if ($err) {
                \Log::error($err);
                return (object)['errorCode'=>'111','message'=>'Request Error','data'=>null];
            } else {
               \Log::info('SMS Response::'.$response);
                return json_decode($response);
            }

    }

    static function get($end_point,$headers=[],$payload=null)
    {

        $headers=array_merge(array(
            "Accept: application/json",
            "Content-Type: application/json",
            "cache-control: no-cache"
        ),$headers);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $end_point,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER =>$headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            \Log::error($err);
            return (object)['errorCode'=>'111','message'=>'Request Error','data'=>null];
        } else {
            \Log::info($response);

          return json_decode($response);
        }
    }
}

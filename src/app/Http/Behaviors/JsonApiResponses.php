<?php
namespace Zikkio\Http\Behaviors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

/**
 * Trait RespondsToApiRequests
 * Provides ability to generate uniform and coherent responses quickly
 */
trait JsonApiResponses
{
    /**
     * Generates generic response, containing
     * request & response envelopes and
     * any other relevant data to be attached
     *
     * @param $statusCode
     * @param array $additionalData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondJson($statusCode, $additionalData = []){
        $request = request();
        $response = response();

        $requestEnvelope = $this->generateRequestEnvelope($request);
        $responseEnvelope = $this->generateResponseEnvelope($statusCode);

        $responseData = array_merge([
            "requestEnvelope" => $requestEnvelope,
            "responseEnvelope" => $responseEnvelope,
        ], $additionalData);

        return $response->json($responseData, $statusCode);
    }

    /**
     * Basic successful response
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data = [], $statusCode = 200){
        return $this->respondJson($statusCode, [
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Basic unsuccessful response
     * @param string $message
     * @param string $description
     * @param int $code
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message = "", $description = "", $code = 0, $statusCode = 400){
        $message = $message ?: "There was an error";
        $description = $description ?: $message;

        return $this->respondJson($statusCode, [
            'success' => false,
            'error' => [
                'message' => $message,
                'description' => $description,
                'code' => $code,
            ],
        ]);
    }


    /*
        TIME SAVERS
        The following methods are meant to both save time to the developer and make the code more semantic
    */

    protected function respondCreated($data = []){
        return $this->respondSuccess($data, 201);
    }

    protected function respondUnauthenticated($message = "You need authentication to perform this action", $description = "You need authentication to perform this action", $code = 0){
        return $this->respondError($message, $description, $code, 401);
    }

    protected function respondForbidden($message = "You are not allowed to perform this action", $description = "You are not allowed to perform this action", $code = 0){
        return $this->respondError($message, $description, $code, 403);
    }

    protected function respondMethodNotAllowed($message = "This method is not supported on this endpoint", $description = "This method is not supported on this endpoint", $code = 0){
        return $this->respondError($message, $description, $code, 405);
    }

    protected function respondUnexpectedError($message = 'Unexpected Error', $description = 'There has been an internal error processing the request. Please retry', $code = 0){
        return $this->respondError($message, $description, $code, 500);
    }


    protected function generateRequestEnvelope(Request $request)
    {
        $requestEnvelope = [
            "endpoint" => $request->path(),
            "url" => $request->url(),
            "fullUrl" => $request->fullUrl(),
            "method" => $request->method(),
            "ips" => $request->ips(),
            "headers" => $request->headers->all(),
            "isAjax" => $request->ajax(),
            "isPjax" => $request->pjax(),
            "isHttps" => $request->isSecure(),
            "token" => $request->bearerToken(),
            "signature" => "",
        ];
        if($request->route()){
            $requestEnvelope['signature'] = $request->fingerprint();
        }
        return $requestEnvelope;
    }

    protected function generateResponseEnvelope($statusCode)
    {
        return [
            "timestamp" => Carbon::now(),
            "status" => $statusCode,
        ];
    }
}
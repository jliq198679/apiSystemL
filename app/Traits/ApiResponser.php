<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 5/04/21
 * Time: 10:46
 */

namespace App\Traits;


use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * @param $data
     * @param int $statusCode
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function successResponse($data, $statusCode = Response::HTTP_OK)
    {
        return response($data, $statusCode)->header('Content-Type', 'application/json; charset=UTF-8')->header('charset', 'utf-8');
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($errorMessage, $statusCode)
    {
        return response()->json(['error' => $errorMessage, 'error_code' => $statusCode], $statusCode);
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function errorMessage($errorMessage, $statusCode)
    {
        return response($errorMessage, $statusCode)->header('Content-Type', 'application/json');
    }

    public function responseJson(array $data, $statusCode = Response::HTTP_OK)
    {
        $header = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        ];
        return response()->json($data,$statusCode, $header, JSON_UNESCAPED_UNICODE);
    }
}

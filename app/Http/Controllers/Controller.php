<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @return JsonResponse
     */
    final public function responseCreated($data = null): JsonResponse
    {
        return $this->responseSuccess($data, Response::HTTP_CREATED);
    }

    /**
     * @param $data
     * @param  int  $status
     * @return JsonResponse
     */
    final public function responseSuccess($data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'status_code' => $status,
            'data' => $data,
            'errors' => (new \stdClass()),
        ], $status);
    }

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    final public function responseUnprocessableEntityError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $data);
    }

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    final public function responseUnauthorizedEntityError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_UNAUTHORIZED, $data);
    }

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    final public function responseNotFoundError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_NOT_FOUND, $data);
    }

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    final public function responseForbiddenError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_FORBIDDEN, $data);
    }

    /**
     * @param  int  $status
     * @param  array  $data
     * @return JsonResponse
     */
    private function errorResponse(int $status, array $data): JsonResponse
    {
        $response = [
            'status' => 'error',
            'status_code' => $status,
            'errors' => $data,
        ];

        return response()->json($response, $status);
    }
}

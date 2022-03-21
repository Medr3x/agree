<?php

if (!function_exists('apiResponse')) {
    /**
     * @param $data
     * @param string $message
     * @param string $status
     * @param int $HttpStatus
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponse($data, $message = 'Completado!', $status = 'success', $HttpStatus = 200, $headers = [], $options = 0)
    {
        return response()->json([
            'status' => $status,
            'message' => strip_tags($message),
            'data' => $data,
        ], $HttpStatus, $headers, $options);
    }
}
if (!function_exists('apiExceptionResponse')) {
    /**
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    function apiExceptionResponse($exception)
    {
        report($exception);
        
        return apiResponse(['exception_code' => $exception->getCode()],
            strip_tags($exception->getMessage()), 'error', 400);
    }
}
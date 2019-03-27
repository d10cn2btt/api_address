<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @param $returnCode
 * @param $data
 * @param int $statusCode
 * @return \Illuminate\Http\JsonResponse
 */
function api_response($returnCode, $data, $statusCode = 200)
{
    return response()->json([
        'code' => $returnCode,
        'data' => $data,
    ], $statusCode);
}

/**
 * @param $apiCodeKey
 * @param array $errors
 * @param array $customData
 * @return \Illuminate\Http\JsonResponse
 */
function api_error($apiCodeKey, $errors = [], $customData = [])
{
    $returnCode = config($apiCodeKey);
    $message = trans($apiCodeKey);

    $data = array_merge(['message' => $message], $customData);
    if ($errors) {
        $data['errors'] = $errors;
    }

    return api_response($returnCode, array_merge($data, $customData));
}

/**
 * @param $data
 * @param int $statusCode
 * @return \Illuminate\Http\JsonResponse
 */
function api_success($data, $statusCode = 200)
{
    return api_response(config('api.code.common.request_success'), $data, $statusCode);
}

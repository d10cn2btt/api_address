<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * @apiDefine RequireAuthHeader
 *
 * @apiHeader {String} Authorization Authorization Bearer token after login
 * @apiHeaderExample {json} Header-Example:
 * {
 *     "Authorization": "Bearer jwt-token-after-login"
 * }
 */

class BaseController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param $apiCodeKey
     * @param array $errors
     * @param array $customData
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($apiCodeKey, $errors = [], $customData = [])
    {
        return api_error($apiCodeKey, $errors, $customData);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data, $statusCode = 200)
    {
        return api_success($data, $statusCode);
    }

    public function response404()
    {
        return abort(Response::HTTP_NOT_FOUND);
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ApiValidationException) {
            return $this->apiResponseValidationError($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Custom response when validation failed for api,
     *
     * Return only first error, and return code instead of message
     *
     * @param ApiValidationException $exception
     * @return \Illuminate\Http\Response Config key for error code, see config/api.php
     */
    private function apiResponseValidationError($exception)
    {
        return api_error('api.code.common.validate_failed', Response::HTTP_FORBIDDEN, $exception->errors());
    }
}

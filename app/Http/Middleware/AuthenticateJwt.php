<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;

class AuthenticateJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  bool $optional Default 0: always need authentication, return 401 respone if auth failed
     *                                1: optional, to get user only, no return 401 response
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $this->handleRequireAuth($request, $next);
    }

    private function handleRequireAuth($request, $next)
    {
        if (!$token = JWTAuth::setRequest($request)->getToken()) {
            return api_error('api.code.auth.token_absent');
        }

        try {
            $this->authenticateByToken($token);
        } catch (TokenExpiredException $e) {
            // Token was expired but can be refreshed
            return $this->tryToRefreshTokenWhenExpired($request, $next, false);
        } catch (TokenBlacklistedException $e) {
            return $this->responseTokenBlacklisted();
        } catch (JWTException $e) {
            return $this->responseNeedToLoginAgain();
        }

        return $next($request);
    }

    /**
     * Try to refresh token when current token was expired
     *
     * @param $request
     * @param Closure $next
     * @param $optional
     * @return \Illuminate\Http\JsonResponse|mixed|void
     */
    private function tryToRefreshTokenWhenExpired($request, Closure $next, $optional)
    {
        if ($optional) {
            try {
                $newToken = JWTAuth::refresh();
            } catch (JWTException $e) {
                return $next($request);
            }
        } else {
            try {
                $newToken = JWTAuth::refresh();
            } catch (TokenBlacklistedException $e) {
                return $this->responseTokenBlacklisted();
            } catch (JWTException $e) {
                return $this->responseNeedToLoginAgain();
            }
        }

        // Re-authenticate with new token
        $this->authenticateByToken($newToken);

        // Get next response
        $response = $next($request);

        // Attach the token to the response back to the client
        $response->headers->set('Authorization', config('user.token_type') . $newToken);

        return $response;
    }

    private function responseNeedToLoginAgain()
    {
        return abort(Response::HTTP_UNAUTHORIZED, trans('api.code.auth.token_invalid'));
    }

    private function responseTokenBlacklisted()
    {
        return api_error('api.code.auth.token_blacklisted');
    }

    private function authenticateByToken($token)
    {
        JWTAuth::authenticate($token);
    }
}

<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\AuthenticateJwt;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateJwtTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function tearDown()
    {
    }

    public function test_absent_token()
    {
        $request = new Request();
        $next = function ($request) {
            return 'bar';
        };

        $middleware = new AuthenticateJwt();
        $response = $middleware->handle($request, $next);

        $responseExpected = json_encode([
            'code' => config('api.code.auth.token_absent'),
            'data' => [
                'message' => __('api.code.auth.token_absent'),
            ],
        ]);

        $this->assertJson($response->getContent());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseExpected, $response->getContent());
    }

    public function test_token_invalid()
    {
        $token = JWTAuth::fromUser($this->user) . Str::random(10);

        try {
            $request = new Request();
            $request->headers->set('Authorization', 'Bearer ' . $token);
            $next = function ($request) {
                return 'bar';
            };

            $middleware = new AuthenticateJwt();
            $middleware->handle($request, $next);
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpException::class, $e);
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getStatusCode());
            $this->assertEquals(__('api.code.auth.token_invalid'), $e->getMessage());
        }
    }

    public function test_token_success()
    {
        $token = JWTAuth::fromUser($this->user);
        $expectedResponse = 'bar';
        $request = new Request();
        $request->headers->set('Authorization', 'Bearer ' . $token);
        $next = function ($request) use ($expectedResponse) {
            return $expectedResponse;
        };

        $middleware = new AuthenticateJwt();
        $response = $middleware->handle($request, $next);
        $this->assertEquals($expectedResponse, $response);
    }
}

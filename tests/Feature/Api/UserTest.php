<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $token;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    public function tearDown()
    {
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_profile_lack_address()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put(route('api.me.update'));
        $dataResponse = $response->getContent();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($dataResponse);
        $dataResponse = json_decode($dataResponse);
        $this->assertObjectHasAttribute('code', $dataResponse);
        $this->assertObjectHasAttribute('data', $dataResponse);
    }

    public function test_update_profile_success()
    {
        $addressUpdated = Str::random(10);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put(route('api.me.update'), ['address' => $addressUpdated]);
        $dataResponse = $response->getContent();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($dataResponse);
        $dataResponse = json_decode($dataResponse);
        $this->assertObjectHasAttribute('code', $dataResponse);
        $this->assertObjectHasAttribute('data', $dataResponse);
        $userUpdated = User::find($this->user->id);
        $this->assertEquals($addressUpdated, $userUpdated->address);
    }
}

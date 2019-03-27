<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\Api\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUser(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->response404();
        }

        return $this->responseSuccess([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UserRequest $request)
    {
        $user = auth()->user();

        if (!$this->userService->updateProfile($user, $request->all())) {
            return $this->responseError('api.code.common.update_failed');
        }

        return $this->responseSuccess([
            'user' => new UserResource($user),
        ]);
    }
}

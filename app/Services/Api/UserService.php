<?php

namespace App\Services\Api;

class UserService extends BaseService
{
    public function updateProfile($user, $inputs)
    {
        return $user->update($inputs);
    }
}

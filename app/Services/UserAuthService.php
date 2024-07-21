<?php

namespace App\Services;

use App\Traits\ResponseTrait;

class UserAuthService
{
    use ResponseTrait;

    public function login(array $data)
    {
        try {
            $token = auth('api')->attempt($data);

            if($token)
                return self::successWithData(
                    self::withToken(auth('api')->user(), $token), 'logged in successfully');
            else
                throw new \Exception('bad credentials',401);

        }catch (\Exception $e){
            return self::failed($e->getMessage(), $e->getCode());
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();

            return self::successWithMessage('logged out successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

}

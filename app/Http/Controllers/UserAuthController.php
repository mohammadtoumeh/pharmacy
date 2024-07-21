<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Services\UserAuthService;

class UserAuthController extends Controller
{
    protected UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;

        $this->middleware('auth:api')->only('logout');
    }



    public function login(UserLoginRequest $request)
    {
        return $this->userAuthService->login($request->safe()->all());
    }

    public function logout()
    {
        return $this->userAuthService->logout();
    }


}

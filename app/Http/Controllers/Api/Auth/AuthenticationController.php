<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\Api\ApiAuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private $apiAuthService;

    public function __construct(ApiAuthenticationService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
    }

    public function register(StoreUserRequest $request)
    {
        $this->apiAuthService->register($request);

        return api_response(
            HttpStatus::CREATED,
            'User successfully registered'
        );
    }

    public function login(LoginRequest $request)
    {
        return api_response(
            HttpStatus::OK,
            'Login successful',
            $this->apiAuthService->login($request)
        );
    }

    public function me()
    {
        $user = auth('sanctum')->user();

        return api_response(
            HttpStatus::OK,
            'User fetched',
            $user
        );
    }
}

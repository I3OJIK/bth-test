<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    )
    {}

    /**
     * Авторизация пользователя и получение API-токена.
     *
     * @param LoginRequest $request
     * 
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->authService->login($data);

        return response()->json([
            'token' => $token,
        ]);
    }
}

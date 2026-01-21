<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Логин пользователя и выдача API-токена
     * 
     * @param array $credentials
     * 
     * @throws ValidationException
     * 
     * @return string
     */
    public function login(array $credentials): string
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user
            ->createToken('admin')
            ->plainTextToken;
    }
}

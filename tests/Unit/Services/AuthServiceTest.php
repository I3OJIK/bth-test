<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    #[Test]
    public function can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $token = $this->authService->login([
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }

    #[Test]
    public function throws_exception_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $this->expectException(ValidationException::class);

        $this->authService->login([
            'email' => 'test@example.com',
            'password' => 'wrong-password'
        ]);
    }
}
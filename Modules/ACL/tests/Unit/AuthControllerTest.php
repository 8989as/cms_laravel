<?php

namespace Modules\ACL\Tests\Unit;

use Modules\ACL\App\Http\Controllers\AuthController;
use Modules\ACL\Services\AuthService;
use Modules\ACL\App\Http\Requests\LoginRequest;
use Modules\ACL\App\Http\Requests\ForgotPasswordRequest;
use Tests\TestCase;
use Mockery;

class AuthControllerTest extends TestCase
{
    protected $authService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the AuthService
        $this->authService = Mockery::mock(AuthService::class);

        // Bind the mock to the service container
        $this->app->instance(AuthService::class, $this->authService);
    }

    /**
     * Test login success response.
     */
    public function testLoginSuccess()
    {
      // Mock AuthService login response
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn([
                    'status' => 200,
                    'token' => 'sample_token',
                ]);
        });

        // Simulate a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Assert response format
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Login successful',
        ]);
        $this->assertArrayHasKey('data', $response->json());
        $this->assertArrayHasKey('token', $response->json()['data']);
    }

    public function testLoginWithMissingFields()
    {
        // Simulate a POST request to the login endpoint with missing fields
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com', // Missing password
        ]);

        // Assert response format
        $response->assertStatus(422); // Unprocessable Entity (validation error)
        $response->assertJsonValidationErrors(['password']);
        $responseData = $response->getData(true);

        $this->assertEquals(false, $responseData['success']);
        $this->assertEquals('The password field is required.', $responseData['errors']['password'][0]);
    }

    public function testLoginWithInvalidEmailFormat()
    {
        // Simulate a POST request to the login endpoint with an invalid email format
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email', // Invalid email
            'password' => 'password123',
        ]);

        // Assert response format
        $response->assertStatus(422); // Unprocessable Entity (validation error)
        $response->assertJsonValidationErrors(['email']);
        $responseData = $response->getData(true);

        $this->assertEquals(false, $responseData['success']);
        $this->assertEquals('The email must be a valid email address.', $responseData['errors']['email'][0]);
    }

    public function testLoginWithIncorrectCredentials()
    {
        // Mock AuthService login failure due to incorrect credentials
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn([
                    'error' => 'Invalid credentials',
                    'status' => 401,
                ]);
        });
    
        // Simulate a POST request to the login endpoint with incorrect credentials
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);
    
        // Assert response format
        $response->assertStatus(401); // Unauthorized
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid credentials',
        ]);
    }

    /**
     * Test forgot password success response.
     */
    public function testForgotPasswordSuccess()
    {
        // Mock AuthService forgotPassword success response
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('forgotPassword')
                ->once()
                ->andReturn([
                    'message' => 'Password reset email sent',
                    'status' => 200,
                ]);
        });

        // Simulate a POST request to the forgot password endpoint
        $response = $this->postJson('/api/forgot-password', [
            'email' => 'admin@example.com',
        ]);

        // Assert response format
        $response->assertStatus(200); // Expect HTTP 200: Success
        $response->assertJson([
            'success' => true,
            'message' => 'Password reset email sent',
        ]);
    }

    public function testForgotPasswordWithMissingEmail()
    {
        // Simulate a POST request to the forgot password endpoint with missing email
        $response = $this->postJson('/api/forgot-password', []);

        // Assert response format
        $response->assertStatus(422); // Unprocessable Entity (validation error)
        $response->assertJsonValidationErrors(['email']);
        $responseData = $response->getData(true);

        $this->assertEquals(false, $responseData['success']);
        $this->assertEquals('The email field is required.', $responseData['errors']['email'][0]);
    }

    public function testForgotPasswordWithInvalidEmailFormat()
    {
        // Simulate a POST request to the forgot password endpoint with an invalid email
        $response = $this->postJson('/api/forgot-password', [
            'email' => 'invalid-email', // Invalid email
        ]);

        // Assert response format
        $response->assertStatus(422); // Unprocessable Entity (validation error)
        $response->assertJsonValidationErrors(['email']);
        $responseData = $response->getData(true);

        $this->assertEquals(false, $responseData['success']);
        $this->assertEquals('The email field must be a valid email address.', $responseData['errors']['email'][0]);
    }

    public function testForgotPasswordWithNonexistentEmail()
    {
        // Mock AuthService forgotPassword failure due to nonexistent email
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('forgotPassword')
                ->once()
                ->andReturn([
                    'message' => 'Email not found',
                    'status' => 404,
                ]);
        });

        // Simulate a POST request to the forgot password endpoint
        $response = $this->postJson('/api/forgot-password', [
            'email' => 'nonexistentuser@example.com',
        ]);

        // Assert response format
        $response->assertStatus(404); // Not Found
        $response->assertJson([
            'success' => false,
            'message' => 'Email not found',
        ]);
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Mail\SignupRegistration;
use Illuminate\Support\Facades\Mail;

class RegistrationControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function testValidRegistration()
    {
        // Create a test request with valid data
        $response = $this->json('POST', '/v1/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response has the expected structure
        $response->assertJson([
            'status' => 200,
            'message' => 'Registration was successful',
        ]);

        // Add more assertions to test the database, email verification, etc.
    }

    public function testInvalidRegistration()
    {
        // Create a test request with invalid data
        $response = $this->json('POST', '/v1/register',  [
            'firstname' => '@#@',
            'lastname' => '',
            'email' => '2#3',
            'password' => ' ',
            'password_confirmation' => 'werd123',
        ]);

        // Assert that the response has a 422 status code
        $response->assertStatus(422);

        // Assert that the response has the expected structure for validation errors
        $response->assertJsonStructure([
            'error' => [
                'firstname',
                'lastname',
                'email',
                'password',
            ],
        ]);

        // Add more assertions for specific validation error messages
    }
}
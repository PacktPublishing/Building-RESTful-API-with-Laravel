<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function testLoginLogout()
    {
        $user = factory(User::class)->create();
        $user->save();
        // Login
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(200);
        $token = json_decode($response->getContent(), true)['data']['token'];
        // Get the token. Query self.
        $this->refreshApplication();
        $selfQueryResponse = $this->get('/api/auth/user', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $selfQueryResponse->assertStatus(200);

        // Refresh token
        $this->refreshApplication();
        $tokenRefreshResponse = $this->patch('/api/auth/refresh', [
            //
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $tokenRefreshResponse->assertStatus(200);
        $this->refreshApplication();

        // Logout
        $logoutResponse = $this->delete('/api/auth/invalidate', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $logoutResponse->assertStatus(200);

        // Now you cannot query yourself
        $this->refreshApplication();
        $loggedOutTestQuery = $this->get('/api/auth/user');
        $loggedOutTestQuery->assertStatus(401);
    }
}
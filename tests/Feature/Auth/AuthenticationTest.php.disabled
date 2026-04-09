<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_with_email(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $response = $this->from(route('login'))->postAsForm(route('login'), [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_users_can_authenticate_with_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $response = $this->from(route('login'))->postAsForm(route('login'), [
            'login' => $user->login,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $response = $this->from(route('login'))->postAsForm(route('login'), [
            'login' => $user->login,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        // Breeze utilise POST /logout
        $response = $this->postAsForm(route('logout'));

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login screen can be rendered.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
    }

    /**
     * Test user can authenticate using the login screen.
     */
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'novix@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'novix@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    /**
     * Test users can not authenticate with invalid password.
     */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'novix@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->post('/login', [
            'email' => 'novix@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test registration screen can be rendered.
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Crea tu cuenta');
    }

    /**
     * Test new users can register.
     */
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Mi Pareja',
            'email' => 'pareja@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'pareja@example.com',
            'name' => 'Mi Pareja',
        ]);
        $response->assertRedirect(route('home'));
    }

    /**
     * Test user can log out.
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('home'));
    }

    /**
     * Test home screen redirects guests to login and displays user info when authenticated.
     */
    public function test_home_screen_displays_auth_state_properly(): void
    {
        $guestResponse = $this->get('/');
        $guestResponse->assertRedirect('/login');

        $loginResponse = $this->get('/login');
        $loginResponse->assertSee('Iniciar Sesión');
        $loginResponse->assertSee('Registrarse');
        $loginResponse->assertDontSee('Volver a la lista de regalos');

        $user = User::factory()->create(['name' => 'Carlos']);
        $authResponse = $this->actingAs($user)->get('/');
        $authResponse->assertSee('Carlos');
        $authResponse->assertSee('Salir');
        $authResponse->assertSee('¿Qué regalar a mi novix?');
    }
}

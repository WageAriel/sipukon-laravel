<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard'); // Ganti dengan route setelah login
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => 'invalid@example.com',
            'password' => 'invalidPassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest(); // Pastikan pengguna tidak diautentikasi
    }

    /** @test */
    public function password_is_hashed_when_user_registers()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->assertTrue(Hash::check('password123', $user->password)); // Pastikan password sesuai
    }

    /** @test */
    /** @test */
public function session_is_managed_after_successful_login()
{
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    // Pastikan pengguna terautentikasi
    $this->assertAuthenticatedAs($user);

    // Periksa apakah session berisi ID pengguna
    $this->assertEquals(session('user_id'), $user->id);
}

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_login_dengan_credential_yang_valid()
    {
        $user = User::factory()->create([
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $this->actingAs($user);

        $response = $this->get('/landing');

        $response->assertStatus(200);
        $response->assertSee('LandingPage');
    }

    /** @test */
    public function admin_login_dengan_credential_yang_valid()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('HomeView');
    }

    /** @test */
    public function password_terHash_di_database()
    {
        $user = User::factory()->create([
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);


        $userFromDb = User::where('email', 'user1@example.com')->first();

        $this->assertNotEquals('password123', $userFromDb->password);
        $this->assertTrue(Hash::check('password123', $userFromDb->password), 'Password tidak terenkripsi dengan benar');
    }
    /** @test */
public function login_gagal_dengan_akun_yang_tidak_valid()
{

    $user = User::factory()->create([
        'email' => 'user1@exdddample.com',
        'password' => 'password123',
        'role' => 'user',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'user1@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/login');
    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
}

/** @test */
public function session_user_berhasil_terhapus_saat_logout()
{
    $user = User::factory()->create([
        'email' => 'user1@example.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);

    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
}


}

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
        // Arrange: Buat akun pengguna dengan role 'user'
        $user = User::factory()->create([
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user', // Pastikan role adalah 'user'
        ]);

        // Act: Gunakan actingAs untuk mengeset user yang sedang login
        $this->actingAs($user);

        // Coba akses halaman setelah login
        $response = $this->get('/landing');

        // Assert: Pastikan login berhasil dan user diarahkan ke landing page
        $response->assertStatus(200); // Status OK untuk halaman landing
        $response->assertSee('LandingPage'); // Pastikan halaman landing terlihat
    }

    /** @test */
    public function admin_login_dengan_credential_yang_valid()
    {
        // Arrange: Buat akun pengguna dengan role 'admin'
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Act: Gunakan actingAs untuk mengeset admin yang sedang login
        $this->actingAs($admin);

        // Coba akses halaman setelah login
        $response = $this->get('/dashboard');

        // Assert: Pastikan login berhasil dan admin diarahkan ke dashboard
        $response->assertStatus(200); // Status OK untuk halaman dashboard
        $response->assertSee('HomeView'); // Pastikan halaman dashboard terlihat
    }

    /** @test */
    public function password_terHash_di_database()
    {
        // Arrange: Buat pengguna
        $user = User::factory()->create([
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // Act: Ambil pengguna dari database
        $userFromDb = User::where('email', 'user1@example.com')->first();

        // Assert: Pastikan password di-hash dan tidak sama dengan password plaintext
        $this->assertNotEquals('password123', $userFromDb->password);
        $this->assertTrue(Hash::check('password123', $userFromDb->password), 'Password tidak terenkripsi dengan benar');
    }
    /** @test */
public function login_gagal_dengan_akun_yang_tidak_valid()
{
    // Arrange: Buat pengguna dengan password yang benar
    $user = User::factory()->create([
        'email' => 'user1@example.com',
        'password' => bcrypt('password123'), // Password yang di-hash
        'role' => 'user',
    ]);

    // Act: Coba login dengan password yang salah
    $response = $this->from('/login')->post('/login', [
        'email' => 'user1@example.com',
        'password' => 'wrongpassword', // Password yang salah
    ]);

    // Assert: Pastikan login gagal dan pengguna diarahkan kembali ke login
    $response->assertStatus(302); // Status redirect
    $response->assertRedirect('/login'); // Redirect kembali ke login
    $response->assertSessionHasErrors(['email']); // Pastikan ada error pada session untuk email
    $this->assertGuest(); // Pastikan pengguna tidak terautentikasi
}

/** @test */
public function session_user_berhasil_terhapus_saat_logout()
{
    // Arrange: Buat dan login sebagai pengguna
    $user = User::factory()->create([
        'email' => 'user1@example.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);

    $this->actingAs($user);

    // Act: Logout pengguna
    $response = $this->post('/logout');

    // Assert: Pastikan pengguna diarahkan ke halaman utama dan tidak lagi terautentikasi
    $response->assertRedirect('/'); // Redirect ke halaman utama setelah logout
    $this->assertGuest(); // Pastikan pengguna tidak terautentikasi
}


}

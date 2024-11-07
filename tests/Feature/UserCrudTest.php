<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Hash;


class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
{
    parent::setUp();
    // Nonaktifkan CSRF token untuk pengujian ini
    $this->withoutMiddleware(VerifyCsrfToken::class);
}
    

    /** @test */
    public function it_can_register_a_user()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama' => 'Test User',
        ]);
        // dd($response->getContent());

        // Memastikan pengguna diarahkan ke halaman login setelah registrasi
        $response->assertRedirect(route('login'));
        
        // Memastikan pengguna baru ada di database
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'nama' => 'Test User', // Memastikan nama juga tersimpan
        ]);
    }

/** @test */
// tests/Feature/UserCrudTest.php
public function it_can_display_user_profile_after_login()
{
    // Buat pengguna terlebih dahulu
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
        'nama' => 'Test User',
    ]);

    // Login menggunakan kredensial pengguna
    $this->post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    // Mengakses halaman profil setelah login
    $response = $this->get(route('profile.show'));

    // Memastikan respons sukses
    $response->assertStatus(200);

    // Memastikan bahwa nama dan email pengguna terlihat di halaman
    $response->assertSee('Test User'); // Memeriksa nama pengguna
    $response->assertSee('test@example.com'); // Memeriksa email pengguna
}


/** @test */
public function it_can_change_password()
{
    // Membuat pengguna dengan atribut lengkap
    $user = User::factory()->create([
        'name' => 'testuser', // Tambahkan username
        'email' => 'test@example.com', // Tambahkan email
        'password' => bcrypt('oldpassword'), // Password lama
        'nama' => 'Test User', // Nama yang mungkin diperlukan
    ]);

    // Melakukan login sebagai pengguna yang baru dibuat
    $this->actingAs($user);

    // Mengirim permintaan untuk mengubah password
    $response = $this->post(route('password.update'), [
        'old_password' => 'oldpassword',
        'password' => 'newpassword', // Password baru
        'password_confirmation' => 'newpassword', // Konfirmasi password baru
    ]);

    // Memastikan pengguna diarahkan kembali ke profil
    $response->assertRedirect(route('profile.show'));

    // Memastikan bahwa password baru disimpan di database
    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
}






    
}

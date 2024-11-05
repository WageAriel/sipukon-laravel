<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // Fungsi setup untuk membuat admin user
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    // Test untuk fungsi create data (menambah data)
    public function test_admin_can_create_user()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    // Test untuk fungsi read data (menampilkan data)
    public function test_admin_can_view_users()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/dashboard/user');
        $response->assertStatus(200);
        $response->assertSee('User Data'); // Pastikan halaman memuat data user
    }

    // Test untuk fungsi update data (mengubah data)
    public function test_admin_can_update_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
        ]);

        $response = $this->put("/users/{$user->id}", [
            'name' => 'Jane Updated',
            'email' => 'janeupdated@example.com',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'janeupdated@example.com']);
    }

    // Test untuk fungsi delete data (menghapus data)
    public function test_admin_can_delete_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $response = $this->delete("/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Test validasi input data (field kosong atau tidak valid)
    public function test_validation_fails_when_required_fields_are_missing()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/users', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    // Test untuk mengubah data yang tidak ada
    public function test_admin_cannot_update_non_existent_user()
    {
        $this->actingAs($this->admin);

        $response = $this->put('/users/9999', [
            'name' => 'Non Existent',
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertStatus(404);
    }

    // Test untuk menghapus data yang sedang digunakan oleh fitur lain
    public function test_admin_cannot_delete_user_if_in_use()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();
        // Simulate that user is in use by creating related data here
        // Misalnya dengan model Relasi lain yang bergantung pada user

        $response = $this->delete("/users/{$user->id}");
        $response->assertStatus(409); // Contoh status untuk konflik penghapusan
    }

    // Test untuk akses tanpa hak akses yang sesuai
    public function test_non_admin_user_cannot_perform_crud_operations()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // Test Create
        $response = $this->post('/users', [
            'name' => 'No Access User',
            'email' => 'noaccess@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);
        $response->assertStatus(403); // Akses ditolak

        // Test Update
        $response = $this->put("/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
        $response->assertStatus(403); // Akses ditolak

        // Test Delete
        $response = $this->delete("/users/{$user->id}");
        $response->assertStatus(403); // Akses ditolak
    }
}

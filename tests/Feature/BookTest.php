<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_dapat_menambah_buku()
    {
        $this->actingAs($this->adminUser)->withoutMiddleware();

        $response = $this->post(route('buku.store'), [
            'title' => 'Book Title',
            'author' => 'Author Name',
            'isbn' => '9781234567890',
            'publisher' => 'Publisher Name',
            'tahun' => 2023, 
            'cover_image' => UploadedFile::fake()->image('cover.jpg')
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('buku', [
            'title' => 'Book Title',
            'author' => 'Author Name',
            'isbn' => '9781234567890',
            'publisher' => 'Publisher Name',
            'tahun' => 2023,
        ]);
    }

    /** @test */
    public function admin_dapat_melihat_list_buku()
    {
        $this->actingAs($this->adminUser)
             ->withoutMiddleware();

        Book::factory()->create(['title' => 'Book Title']);

        $response = $this->get(route('buku'));

        $response->assertStatus(200);
        $response->assertSee('Book Title');
    }

    /** @test */
    public function admin_dapat_update_data_buku()
    {
        $this->actingAs($this->adminUser)
             ->withoutMiddleware();

        $book = Book::factory()->create();

        $response = $this->put(route('buku.update', $book->id), [
            // 'title' => 'Updated Title',
            'author' => 'Updated Author',
            'isbn' => '9780987654321', 
            'publisher' => 'Updated Publisher',
            'tahun' => 2024,
            'cover_image' => UploadedFile::fake()->image('new_cover.jpg')
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('buku', [
            'author' => 'Updated Author',
            'isbn' => '9780987654321',
            'publisher' => 'Updated Publisher',
            'tahun' => 2024,
        ]);
    }

    /** @test */
    public function admin_dapat_menghapus_data_buku()
    {
        $this->actingAs($this->adminUser)
             ->withoutMiddleware();

        $book = Book::factory()->create();

        $response = $this->delete(route('buku.destroy', $book->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('buku', ['id' => $book->id]);
    }

    /** @test */
    public function selain_admin_tidak_dapat_mengakses_CRUD_buku()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)
             ->withoutMiddleware();

        $response = $this->get(route('buku'));
        $response->assertRedirect(route('landing'))->assertSessionHas('error', 'Unauthorized access.');
    }
}

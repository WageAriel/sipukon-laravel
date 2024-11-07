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
        // Membuat user admin untuk testing
        $this->adminUser = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_dapat_menambah_buku()
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('buku.store'), [
            'title' => '',
            'author' => 'Author Name',
            'description' => 'Description of the book',
            'cover_image' => UploadedFile::fake()->image('cover.jpg')
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseHas('buku', ['author' => 'Author Name']);
    }

    /** @test */
  /** @test */
public function admin_dapat_melihat_list_buku()
{
    $this->actingAs($this->adminUser);

    Book::factory()->create(['title' => 'Book Title']);

    $response = $this->get(route('buku'));

    $response->assertStatus(200);
    $response->assertSee('Book Title');
}


    /** @test */
    public function admin_dapat_update_data_buku()
    {
        $this->actingAs($this->adminUser);

        $book = Book::factory()->create();

        $response = $this->put(route('buku.update', $book->id), [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'description' => 'Updated Description',
            'cover_image' => UploadedFile::fake()->image('new_cover.jpg')
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('buku', ['title' => 'Updated Title']);
    }

    /** @test */
    public function admin_dapat_menghapus_data_buku()
    {
        $this->actingAs($this->adminUser);

        $book = Book::factory()->create();

        $response = $this->delete(route('buku.destroy', $book->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('buku', ['id' => $book->id]);
    }

    /** @test */
    public function selain_admin_tidak_dapat_mengakses_CRUD_buku()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('buku'));
        $response->assertRedirect(route('landing'))->assertSessionHas('error', 'Unauthorized access.');
    }
}

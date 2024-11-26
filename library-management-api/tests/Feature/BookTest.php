<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;

describe('authenticated user', function () {
  beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->seed(CategorySeeder::class);
  });

  test('users can retrieve paginated books', function () {
    Category::create(['category' => 'Category 1']);
    Book::factory(10)->create();
    $response = $this->get('/api/books');

    $response->assertSuccessful();
    $response->assertJsonStructure([
      'current_page',
      'data',
      'first_page_url',
      'last_page_url',
      'last_page',
      'links',
      'next_page_url',
      'path',
      'per_page',
      'prev_page_url',
      'to',
      'total'
    ]);
  });

  //Store Book
  describe('store a book', function () {
    test('can store a book successfully', function () {
      $book = Book::factory()->make();

      $data = [
        'categories' =>
          Category::inRandomOrder()
              ->take(2)
              ->pluck('id')
              ->toArray(),
        ...$book->toArray()
      ];

      $response = $this->postJson('/api/books', $data);

      $response->assertSuccessful();
      $this->assertDatabaseHas('books', [
        'title' => $book->title
      ]);
    });

    test('missing required title field returns validation error', function () {
      Category::create(['category' => 'Category 1']);
      $book = Book::factory()->make();
      //Remove title
      unset($book['title']);
      $response = $this->post('/api/books', $book->toArray());

      $response->assertInvalid(['title']);
    });
  });

  //Update Book
  describe('update a book', function () {
    test('can update a book title only', function () {
      Category::create(['category' => 'Category 1']);
      $book = Book::factory()->create();
      $response = $this->put('/api/books/' . $book->id, [
        'title' => 'Updated Book'
      ]);

      $response->assertSuccessful();
      $this->assertDatabaseHas('books', [
        'title' => 'Updated Book'
      ]);
    });

    test('can update a book\'s info', function () {
      $updatedInfo = [
        'title' => 'Updated Book',
        'quantity' => 200,
        'price' => 1500,
      ];

      $book = Book::factory()->create();
      $response = $this->put('/api/books/' . $book->id, $updatedInfo);

      $response->assertSuccessful();
      $this->assertDatabaseHas('books', $updatedInfo);
    });
  });

  //Delete Book
  describe('delete book', function () {
    test('valid id for book', function () {
      $book = Book::factory()->create();

      $response = $this->delete('/api/books/'.$book->id);
      $response->assertSuccessful();
      $this->assertSoftdeleted($book);
    });

    test('invalid id for a book returns not found', function () {
      $response = $this->delete('/api/books/1');
      $response->assertNotFound();
    });
  });
});
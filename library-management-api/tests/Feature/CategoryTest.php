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

  test('users can retrieve paginated categories', function () {
    $response = $this->getJson('/api/category');

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

  test('can retrieve books by category id', function () {
    Book::factory(10)->create();
    $category = Category::inRandomOrder()->first();
    $response = $this->getJson('/api/category/' . $category->id);

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
  describe('store a category', function () {
    test('can store a book successfully', function () {
      $data = ['category' => 'Sample Category'];
      $response = $this->postJson('/api/category', $data);

      $response->assertSuccessful();
      $this->assertDatabaseHas('categories', $data);
    });

    test('missing required title field returns validation error', function () {
      $response = $this->post('/api/category', []);
      $response->assertInvalid(['category']);
    });
  });

  //Update Book
  describe('update a category', function () {
    test('can update a category', function () {
      $category = Category::inRandomOrder()->first();
      $response = $this->putJson('/api/category/' . $category->id, [
        'category' => 'Updated Category'
      ]);

      $response->assertSuccessful();
      $this->assertDatabaseHas('categories', [
        'category' => 'Updated Category'
      ]);
    });
  });

  //Delete Book
  describe('delete a category', function () {
    test('existing category', function () {
      $category = Category::create(['category' => 'Category 1']);

      $response = $this->delete('/api/category/' . $category->id);
      $response->assertSuccessful();
      $this->assertSoftdeleted($category);
    });

    test('non-existing category', function () {
      $response = $this->delete('/api/category/1');
      $response->assertNotFound();
    });
  });
});
<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;

describe('issue a book', function () {
  beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->seed(CategorySeeder::class);
  });

  test('can get all issued books', function () {
    $response = $this->getJson('/api/issue-book');

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

  test('librarian can issue a book to a user', function () {
    $user = User::factory()->create(['type' => 'Member']);
    $book = Book::factory()->create(); //minimum quantity is 10
    $prevQuantity = $book->quantity;

    $data = [
        'member_id' => $user->id,
        'book_id' => $book->id,
        'issued_at' => now(),
        'quantity' => 5,
    ];

    $response = $this->postJson('/api/issue-book', $data);

    $response->assertSuccessful();
    expect($book->fresh()->quantity)->toBe($prevQuantity - 5);
  });

  test('user cannot borrow more than the book quantity', function () {
    $user = User::factory()->create(['type' => 'Member']);
    $book = Book::factory()->create(); //minimum quantity is 10

    $data = [
        'member_id' => $user->id,
        'book_id' => $book->id,
        'issued_at' => now(),
        'quantity' => 100,
    ];

    $response = $this->postJson('/api/issue-book', $data);

    $response->assertInvalid(['quantity']);
  });
});
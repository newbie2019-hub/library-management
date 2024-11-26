<?php

use App\Models\Author;
use App\Models\User;

describe('authenticated user', function () {
  beforeEach(function () {
    $this->actingAs(User::factory()->create());
  });

  test('users can retrieve authors (paginated)', function () {
    Author::factory(20)->create();
    $response = $this->getJson('/api/authors');

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
  describe('store an author', function () {
    test('can store an author successfully', function () {
      $author = Author::factory()->make();
      $response = $this->post('/api/authors', $author->toArray());

      $response->assertSuccessful();
      $this->assertDatabaseHas('authors', [
        'author' => $author->author
      ]);
    });

    test('missing required title field returns validation error', function () {
      $response = $this->post('/api/authors', []);
      $response->assertInvalid(['author']);
    });
  });

  //Update Book
  describe('update an author', function () {
    test('can update a an author', function () {
      $data = ['author' => 'John Doe'];

      $author = Author::factory()->create();
      $response = $this->put('/api/authors/' . $author->id, $data);

      $response->assertSuccessful();
      $this->assertDatabaseHas('authors', $data);
    });

    test('missing author field', function () {
      $data = [];

      $author = Author::factory()->create();
      $response = $this->putJson('/api/authors/' . $author->id, $data);

      $response->assertInvalid(['author']);
    });
  });

  //Delete Book
  describe('delete author', function () {
    test('valid id for author', function () {
      $author = Author::factory()->create();

      $response = $this->delete('/api/authors/'.$author->id);
      $response->assertSuccessful();
      $this->assertSoftdeleted($author);
    });

    test('returns not found invalid id for an author', function () {
      $response = $this->delete('/api/authors/1');
      $response->assertNotFound();
    });
  });
});
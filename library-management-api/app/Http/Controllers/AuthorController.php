<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::query()
            ->withCount('books')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%');
            })->paginate($request->per_page ?? 15);

        return response()->data($authors);
    }

    public function getAllAuthors()
    {
        $authors = Author::select('id', 'author')->get();
        return response()->data($authors);
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());
        return response()->success($author, 'Author has been saved successfully!');
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return response()->success($author->fresh(), 'Author has been updated');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return response()->noContent();
    }
}

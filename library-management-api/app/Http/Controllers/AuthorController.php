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
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%'. $search .'%');
            })->paginate($request->per_page ?? 15);

        return response()->success($authors);
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());
        return response()->success($author);
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return response()->success($author->fresh());
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return response()->success(['message' => 'Author has been deleted successfully!']);
    }
}

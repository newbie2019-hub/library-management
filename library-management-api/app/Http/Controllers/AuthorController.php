<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::query()
            ->withCount('books')
            ->when($request->include_record, function ($query, $includes) {
                return match ($includes) {
                    'with_trashed' => $query->withTrashed(),
                    'only_trashed' => $query->onlyTrashed()
                };
            })
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
        try {
            DB::beginTransaction();

            $author->delete();
            $author->books()->delete();

            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->error('Error deleting author record: ' . $e->getMessage());
        }
    }

    public function restore(Author $author)
    {
        $author->restore();
        return response()->noContent();
    }
}

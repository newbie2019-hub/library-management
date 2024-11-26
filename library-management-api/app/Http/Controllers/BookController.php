<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::query()
                ->with(['categories:id,category','author'])
                ->when($request->search, function ($query, $search) {
                    return $query->where('title', 'LIKE', '%' . $search . '%');
                })->paginate($request->per_page ?? 15);

        return response()->success($books);
    }

    public function store(BookRequest $request)
    {
        try {
            DB::beginTransaction();

            $book = Book::create($request->safe()->except(['categories']));
            $categoriesId = $request->safe()->only(['categories'])['categories'];

            $book->categories()->sync($categoriesId);
            $book->load('categories:id,category');

            DB::commit();
            return response()->success($book);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->error('Error creating a book record: ' . $e->getMessage());
        }
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $data = $request->validated();
        if ($request->has('categories')) {
            $data = $request->validated()->except(['categories']);
        }

        $book->update($data);
        return response()->success($book->fresh());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->success([
            'message' => 'Book has been deleted successfully!'
        ]);
    }
}

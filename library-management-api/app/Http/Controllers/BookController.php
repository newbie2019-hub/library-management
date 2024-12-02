<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $books = Book::query()
                ->with(['categories:id,category','author:id,author'])
                ->where(fn ($query) =>
                    $query->when($request->category, function ($query, $category) {
                        return match ($category) {
                            'categorized' => $query->has('categories'),
                            'uncategorized' => $query->doesntHave('categories')
                        };
                    })->when($request->included_quantity, function ($query, $category) {
                        return match ($category) {
                            'out_of_stock' => $query->where('quantity', 0),
                            'with_stocks' => $query->where('quantity', '>=', 1)
                        };
                    })
                )
                ->when($request->search, function ($query, $search) {
                    return $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('isbn_no', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('categories', 'category', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('author', 'author', 'LIKE', '%' . $search . '%');
                })->paginate($request->per_page ?? 15);

        return response()->success($books);
    }

    public function summary()
    {
        $totalBooks = Book::sum('quantity');
        $uncategorized = Book::doesntHave('categories')->count();
        $unreturnedBooks = 0;
        $categoriesCount = Category::count();

        return response()->success([
            'total_books' => $totalBooks,
            'uncategorized' => $uncategorized,
            'unreturnedBooks' => $unreturnedBooks,
            'categories_count' => $categoriesCount
        ]);
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

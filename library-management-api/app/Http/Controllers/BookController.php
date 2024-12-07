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
            ->with(['categories:id,category', 'author:id,author'])
            ->where(
                fn($query) =>
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
                })->when($request->search, function ($query, $search) {
                    return $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('isbn_no', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('categories', 'category', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('author', 'author', 'LIKE', '%' . $search . '%');
                })
            )
            ->when($request->include_record, function ($query, $includes) {
                return match ($includes) {
                    'with_trashed' => $query->withTrashed(),
                    'only_trashed' => $query->onlyTrashed()
                };
            })->paginate($request->per_page ?? 15);

        return response()->data($books);
    }

    public function summary()
    {
        $totalBooks = Book::count();
        $uncategorized = Book::doesntHave('categories')->count();
        $unreturnedBooks = 0;
        $categoriesCount = Category::count();

        return response()->data([
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
            return response()->success($book, 'Book has been saved successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            return response()->error('Error creating a book record: ' . $e->getMessage());
        }
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $data = $request->validated();
        if ($request->has('categories')) {
            $data = $request->safe()->except(['categories']);
        }

        $book->update($data);
        return response()->success($book->fresh(), 'Book has been updated successfully!');
    }

    public function restore(Book $book)
    {
        try {
            DB::beginTransaction();

            $book->restore();
            $book->issuedBooks()->each()->restore();

            DB::commit();
            return response()->success([
                'message' => 'Book has been restored successfully!'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->error('Error creating a book record: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        try {
            DB::beginTransaction();

            $book->delete();
            $book->issuedBooks()->delete();  //Delete related records

            DB::commit();
            return response()->success([
                'message' => 'Book has been deleted successfully!'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->error("Error deleting book {$book->id} and its related records: " . $e->getMessage());
        }
    }
}

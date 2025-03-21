<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->withCount('books')
            ->when($request->search, function ($query, $search) {
                return $query->where('category', 'LIKE', '%' . $search . '%');
            })
            ->when($request->include_record, function ($query, $includes) {
                return match ($includes) {
                    'with_trashed' => $query->withTrashed(),
                    'only_trashed' => $query->onlyTrashed()
                };
            })->paginate($request->per_page ?? 15);

        return response()->data($categories);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->success($category, 'Category has been added successfully!');
    }

    public function show(Request $request, Category $category)
    {
        $books = Book::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%');
            })
            ->whereHas(
                'categories',
                fn(Builder $query) =>
                $query->where('category_id', $category->id)
            )->paginate($request->per_page ?? 15);

        return response()->success($books);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        $category->loadCount('books');
        return response()->success($category, 'Category has been updated successfully!');
    }

    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            $category->delete();
            $category->books()->delete();

            DB::commit();
            return response()->success(null, 'Category has been deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->error('Error deleting a category: ' . $e->getMessage());
        }
    }

    public function restore(Category $category)
    {
        $category->restore();
        return response()->success(null, 'Category has been restored successfully!');
    }
}

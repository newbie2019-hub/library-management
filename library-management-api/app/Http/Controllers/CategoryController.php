<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->withCount('books')
            ->when($request->search, function ($query, $search) {
                return $query->where('category', 'LIKE', '%' . $search . '%');
            })->paginate($request->per_page ?? 15);

        return response()->success($categories);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->success($category);
    }

    public function show(Request $request, Category $category) {
        $books = Book::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%');
            })
            ->whereHas('categories', fn (Builder $query) =>
                $query->where('category_id', $category->id))
            ->paginate($request->per_page ?? 15);

        return response()->success($books);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->success($category->fresh());
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->success('Book has been deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Book;
use App\Models\Category;
use App\Models\IssuedBook;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $books = Book::count();
        $members = User::where('type', RoleEnum::MEMBER)->count();
        $categories = Category::count();

        $latestIssuedBooks = IssuedBook::latest()->take(8);
        $latestAddedBooks = Book::latest()->take(8);

        return response()->success([
            'book_count' => $books,
            'members_count' => $members,
            'categories_count' => $categories,
            'latest_issued_books' => $latestIssuedBooks,
            'latest_added_books' => $latestAddedBooks
        ]);
    }
}

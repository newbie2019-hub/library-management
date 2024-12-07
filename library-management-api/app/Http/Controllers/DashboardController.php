<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\IssuedBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $booksCount = Book::count();
        $categoriesCount = Category::count();
        $authorsCount = Author::count();
        $issuedBookCount = IssuedBook::query()
            ->whereBetween('issued_at', [now()->subWeek(), now()])
            ->sum('quantity');

        $latestIssuedBooks = IssuedBook::query()
            ->with([
                'book:id,title,cover_photo',
                'member:id,first_name,last_name,profile_photo',
                'librarian:id,first_name,last_name,profile_photo'
            ])
            ->latest()->take(8)->get();

        $overdueBooks = IssuedBook::query()
            ->overdue()
            ->with([
                'book:id,title,cover_photo',
                'member:id,first_name,last_name,profile_photo',
                'librarian:id,first_name,last_name,profile_photo'
            ])
            ->take(8)
            ->get();

        $overdueBooksCount = IssuedBook::query()
            ->overdue()
            ->whereBetween('issued_at', [now()->subWeek(), now()])
            ->sum('quantity');

        $chartData = IssuedBook::query()
            ->select(
                DB::raw('DATE(issued_at) as issued_date'), // Extract the date part
                DB::raw('CAST(SUM(quantity) AS UNSIGNED) as total_quantity') // Sum the quantities
            )
            ->whereBetween('issued_at', [now()->subWeek(), now()])
            ->groupBy('issued_date')
            ->get();

        return response()->data([
            'book_count' => $booksCount,
            'issued_book_count' => $issuedBookCount,
            'author_count' => $authorsCount,
            'categories_count' => $categoriesCount,
            'latest_issued_books' => $latestIssuedBooks,
            'overdue' => [
                'books' => $overdueBooks,
                'total_count' => $overdueBooksCount
            ],
            'chartData' => $chartData
        ]);
    }
}

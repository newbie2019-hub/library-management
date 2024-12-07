<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssuedBookRequest;
use App\Models\Book;
use App\Models\IssuedBook;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuedBookController extends Controller
{
    public function index(Request $request)
    {
        $issuedBooks = IssuedBook::query()
            ->with([
                'book:id,title',
                'librarian:id,first_name,last_name',
                'member:id,first_name,last_name',
                'returnedBooks'
            ])
            ->when($request->search, function ($query, $search) {
                return $query->whereRelation('book', 'title', 'LIKE', '%' . $search . '%');
            })->paginate($request->per_page ?? 15);

        return response()->success($issuedBooks);
    }

    public function store(IssuedBookRequest $request)
    {
        try {
            DB::beginTransaction();

            $book = Book::where('id', $request->book_id)->first();
            $book->decrement('quantity', $request->quantity);

            $issuedBook = IssuedBook::create([
                ...$request->validated(),
                'user_id' => auth()->id()
            ]);
            $issuedBook->load('book', 'member', 'librarian');

            DB::commit();
            return response()->success($issuedBook);
        } catch(Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return response()->error('Error issuing a book: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request, IssuedBook $issuedBook)
    {
        $issuedBook->update([
            'delete_remarks' => $request->remarks
        ]);

        $issuedBook->delete();
        return response()->success('Issued book record has been deleted');
    }
}

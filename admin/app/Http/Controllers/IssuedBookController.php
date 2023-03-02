<?php

namespace App\Http\Controllers;

use App\Enums\IssuedBookStatus;
use App\Http\Requests\StoreIssuedBookRequest;
use App\Models\Book;
use App\Models\IssuedBook;
use App\Models\User;
use App\Notifications\BookOverdueNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class IssuedBookController extends Controller
{
    public function index()
    {
        $issuedBooks = IssuedBook::with(['book', 'user'])->paginate(7);
        $users = User::whereRelation('role', 'main_role', 'member')->get();
        $books = Book::all();
        return view('admin.issuedBooks.index', compact('issuedBooks', 'users', 'books'));
    }

    public function store(StoreIssuedBookRequest $request)
    {
        $inputs = $request->validated();

        $recordExists = IssuedBook::where(function (Builder $query) use ($inputs) {
            $query->where('user_id', $inputs['user_id'])
                ->where('book_id', $inputs['book_id']);
        })->exists();

        if ($recordExists) {
            return back()->with('recordExists', 'You have already issued selected book to that user');
        }

        $duration = $inputs['duration'];
        $inputs['due_date'] = Carbon::now()->addDays($duration);

        IssuedBook::create($inputs);

        return back()->with(['success' => 'Book was issued to the user sucessfully']);
    }

    public function notifyUser(int $id)
    {
        $data = IssuedBook::with('book')->firstWhere('id', $id);
        $user = User::find($data->user_id);
        $user->notify(new BookOverdueNotification($data));

        return back();
    }

    public function destroy($id)
    {
        $status = IssuedBook::firstWhere('id', $id)->status;
        if (!$status === IssuedBookStatus::Issued) {
            IssuedBook::find($id)->delete();
            return back()->with('removed', 'Selected issued record was removed');
        } else {
            return back()->with('denied', 'Selected issued record can\' be deleted currently');
        }
    }
}

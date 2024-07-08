<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index(Library $library)
    {
        return Inertia::render('Book/Index', [
            'library' => $library,
            'books' => $library->books,
        ]);
    }

    // public function create()
    // {
    //     return Inertia::render('Book/Create');
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'library_id' => 'required',
            'key' => 'required',
            'data' => 'required',
        ]);

        $book = Book::create($data);

        session()->flash('message', 'Book added successfully!');

        return redirect()->back();
    }

    // public function show($id)
    // {
    //     //
    // }

    // public function edit()
    // {
    //     //
    // }

    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function destroy(Library $library, Book $book)
    {
        $book->delete();

        session()->flash('message', 'Book deleted successfully!');

        return redirect()->back();
    }

    public function books(Library $library)
    {
        $user = Auth::user();

        if ($user->id !== $library->user_id) {
            return back()->withErrors('You are not authorized to view this library\'s books.');
        }

        return $library->books;
    }
}

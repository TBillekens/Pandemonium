<?php

namespace App\Http\Controllers;

use App\Models\Library;

use Illuminate\Http\Request;
use App\Models\Book;
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
            'data' => 'required',
        ]);

        $book = Book::create($data);

        session()->flash('message', 'Book created successfully!');

        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    // public function edit()
    // {
    //     //
    // }

    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function destroy(Book $book)
    {
        $book->delete();

        session()->flash('message', 'Book deleted successfully!');

        return redirect()->back();
    }
}

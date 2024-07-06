<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;


class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::all();

        return Inertia::render('Library/Index', [
            'libraries' => $libraries,
        ]);
    }

    public function show(Library $library)
    {
        $books = $library->books;

        return Inertia::render('Library/Show', [
            'library' => $library,
            'books' => $books,
        ]);
    }

    public function create()
    {
        return Inertia::render('Library/Create');
    }

    public function edit(Library $library)
    {
        return Inertia::render('Library/Edit', [
            'library' => $library,
        ]);
    }

    public function destroy(Library $library)
    {
        $library->delete();

        return redirect()->route('library.index');
    }

    public function update(Request $request, Library $library)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'title' => 'required|string',
        ]);

        $library->update($data);

        return redirect()->route('library.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'title' => 'required|string',
        ]);

        Library::create($data);

        return redirect()->route('library.index');
    }
}

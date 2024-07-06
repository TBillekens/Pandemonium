<?php

namespace App\Http\Controllers;

use App\Models\Library;

use Illuminate\Http\Request;
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

    public function create()
    {
        return Inertia::render('Book/Create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

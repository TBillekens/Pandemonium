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

    public function show($id)
    {
        return Inertia::render('Library/Show', [
            'id' => $id,
        ]);
    }

    public function create()
    {
        error_log('create');
        return Inertia::render('Library/Create');
    }

    public function edit($id)
    {
        return Inertia::render('Library/Edit', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
    }

    public function store(Request $request)
    {
        if ($request->has('id')) {
            $data = $request->validate([
                'id' => 'required|integer',
                'title' => 'required|string',
            ]);

            Library::where('id', $data['id'])->update($data);
        } else {
            $data = $request->validate([
                'id' => 'integer|string|required',
                'title' => 'required|string|required',
            ]);

            Library::create($data);
        }

        return redirect()->route('library-index');
    }
}

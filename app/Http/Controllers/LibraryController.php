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
        return Inertia::render('Library/Create');
    }

    public function edit($id)
    {
        $library = Library::find($id);

        return Inertia::render('Library/Edit', [
            'library' => $library,
        ]);
    }

    public function destroy($id)
    {
        Library::destroy($id);

        return redirect()->route('library.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'title' => 'required|string',
        ]);

        Library::where('id', $id)->update($data);

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

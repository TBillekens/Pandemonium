<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class LibraryController extends Controller
{
    public function index()
    {
        return Inertia::render('Library/Index');
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
        return Inertia::render('Library/Edit', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
    }
}

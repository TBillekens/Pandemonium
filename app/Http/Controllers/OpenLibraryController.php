<?php

namespace App\Http\Controllers;

use App\Services\OpenLibraryService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class OpenLibraryController extends Controller
{
    public function index() {
        $libraries = Auth::user()->libraries;

        return Inertia::render('OpenLibrary/Index', [
            'libraries' => $libraries
        ]);
    }

    public function search(OpenLibraryService $openLibraryService) {
        $query = request('searchItem');
        $response = $openLibraryService->search($query); 

        return response()->json($response);
    }
}     
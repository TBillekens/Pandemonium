<?php

namespace App\Http\Controllers;

use App\Services\OpenLibraryService;
use Inertia\Inertia;

class OpenLibraryController extends Controller
{
    public function index() {
        return Inertia::render('OpenLibrary/Index');
    }

    public function search(OpenLibraryService $openLibraryService) {
        $query = request('searchItem');
        $response = $openLibraryService->search($query); 

        return response()->json($response);
    }

}     
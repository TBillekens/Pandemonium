<?php

namespace App\Http\Controllers;

use App\Services\OpenLibraryService;

class OpenLibraryController extends Controller
{
    public function search(OpenLibraryService $openLibraryService) {
        $query = request('q');
        $response = $openLibraryService->search($query); 

        return response()->json($response);
    }
}     
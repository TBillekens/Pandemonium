<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenLibraryService extends Service
{
    private $url;

    public function __construct()
    {
        $this->url = config('services.openlibrary.url') . '/search.json';
    }

    public function request($method, $params = [], $headers = [])
    {
        $response = Http::withHeaders($headers)->$method($this->url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Request failed: ' . $response->status() . ' ' . $response->body());
    }

    public function search($query)
    {
        $response = $this->request('get', ['q' => $query]);

        return $response;
    }
}
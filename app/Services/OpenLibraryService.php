<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenLibraryService extends Service
{
    private $url;
    private $coverUrl;

    public function __construct()
    {
        $this->url = config('services.openlibrary.url') . '/search.json';
        $this->coverUrl = config('services.openlibrary.covers_url');
    }

    public function request($url, $method, $params = [], $headers = [])
    {
        $response = Http::withHeaders($headers)->$method($this->url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Request failed: ' . $response->status() . ' ' . $response->body());
    }

    public function search($query)
    {
        $response = $this->request($this->url, 'get', ['q' => $query]);

        return $response;
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SearchDropdown extends Component
{
    public $search = '';

    public $searchResults = [];

    public function render()
    {
        if (strlen($this->search) < 2) {
            $this->searchResults = [];
        } elseif (!empty(config('services.igdb.client_id')) && !empty(config('services.igdb.client_secret'))) {
            $accessToken = $this->getAccessToken();
            if ($accessToken) {
                $escapedSearch = str_replace(['\\', '"'], ['\\\\', '\\"'], $this->search);
                $response = Http::withHeaders([
                    'Client-ID' => config('services.igdb.client_id'),
                    'Authorization' => 'Bearer ' . $accessToken,
                ])
                    ->withBody(
                        "fields name, cover.url, first_release_date, platforms.abbreviation, rating, summary, slug;
                     where platforms = (48,49,130,6)
                     & name ~ \"{$escapedSearch}\";
                     limit 8;",
                        'text/plain'
                    )
                    ->post('https://api.igdb.com/v4/games');

                $this->searchResults = $this->formatForView($response->successful() ? ($response->json() ?? []) : []);
            } else {
                $this->searchResults = [];
            }
        } else {
            $this->searchResults = [];
        }

        return view('livewire.search-dropdown');
    }

    protected function getAccessToken(): ?string
    {
        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => config('services.igdb.client_id'),
            'client_secret' => config('services.igdb.client_secret'),
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json()['access_token'] ?? null;
    }

    protected function formatForView(array $games): array
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']['url'])
                    ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                    : 'https://via.placeholder.com/264x352',
                'rating' => isset($game['rating']) ? round((float) $game['rating']) . '%' : null,
                'platforms' => isset($game['platforms'])
                    ? collect($game['platforms'])->pluck('abbreviation')->implode(', ')
                    : 'N/A',
            ]);
        })->toArray();
    }
}

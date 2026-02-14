<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ComingSoon extends Component
{
    public $limit = 4;

    public $comingSoon = [];

    public function mount()
    {
        $this->loadComingSoon();
    }

    public function loadComingSoon()
    {
        $current = Carbon::now()->timestamp;
        $limit = (int) $this->limit ?: 4;

        $this->comingSoon = Cache::remember('coming-soon-' . $limit, 7, function () use ($current, $limit) {
            if (empty(config('services.igdb.client_id')) || empty(config('services.igdb.client_secret'))) {
                return [];
            }
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => config('services.igdb.client_id'),
                'client_secret' => config('services.igdb.client_secret'),
                'grant_type' => 'client_credentials',
            ]);
            
            $accessToken = $response->json()['access_token'];

            return Http::withHeaders([ 
                'Client-ID' => config('services.igdb.client_id'),
                'Authorization' => 'Bearer ' . $accessToken,
            ])->withBody(
                "fields name, slug, cover.url, first_release_date, platforms.abbreviation, rating, summary;
                where platforms = (48,49,130,6)
                & first_release_date > {$current};
                sort first_release_date asc;
                limit {$limit};",
                'text/plain'
            )
            ->post('https://api.igdb.com/v4/games')
            ->json();

        });

        $this->comingSoon = $this->formatForView($this->comingSoon);
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }

    public function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replace('thumb', 'cover_big', $game['cover']['url'] ?? ''),
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
                'platforms' => collect($game['platforms'] ?? [])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }
}

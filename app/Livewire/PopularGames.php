<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PopularGames extends Component
{

    public $popularGames = [];

    public function mount()
    {
        $this->loadPopularGames();
    }

    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;

        $popularGamesUnformatted = Cache::remember('popular-games', 7, function () use ($before, $after) {
            if (empty(config('services.igdb.client_id')) || empty(config('services.igdb.client_secret'))) {
                return [];
            }
            // Step 1: Get the access token
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => config('services.igdb.client_id'),
                'client_secret' => config('services.igdb.client_secret'),
                'grant_type' => 'client_credentials',
            ]);

            if ($response->failed()) {
                throw new \Exception('Failed to retrieve access token: ' . $response->body());
            }

            $accessToken = $response->json()['access_token'];
            // Step 2: Use the access token to fetch popular games
            return Http::withHeaders([
                'Client-ID' => config('services.igdb.client_id'),
                'Authorization' => 'Bearer ' . $accessToken,
            ])
                ->withBody(
                    "fields name, cover.url, first_release_date, platforms.abbreviation, rating, summary, slug;
             where platforms = (48,49,130,6)
             & first_release_date > {$before}
             & first_release_date < {$after};
             sort rating desc;
             limit 12;",
                    'text/plain'
                )
                ->post('https://api.igdb.com/v4/games')
                ->json();
        });

        // dd($this->formatforview($popularGamesUnformatted));

        $this->popularGames = $this->formatforview($popularGamesUnformatted);
    }

    public function render()
    {
        return view('livewire.popular-games');
    }

    public function formatforview($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['rating']) ? round((float) $game['rating']) . '%' : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }
}

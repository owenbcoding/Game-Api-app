<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use App\Livewire\PopularGames;

class PopularGamesTest extends TestCase
{
    public function test_the_popular_games_page_shows_correct_games()
    {

        Http::fake([
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            'https://api.igdb.com/v4/games' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/Rhythm Doctor.json')), true),
                200,
                ['Content-Type' => 'application/json']
            ),
        ]);

        Livewire::test(PopularGames::class)
            ->call('loadPopularGames')
            ->assertSee('Rhythm Doctor');
    }
}

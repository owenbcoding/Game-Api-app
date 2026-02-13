<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use App\Livewire\SearchDropdown;

class SearchDropdownTest extends TestCase
{
    public function test_the_search_dropdown_shows_correct_games()
    {
        Http::fake([
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            'https://api.igdb.com/v4/games' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/Rhythm Doctor.json')), true),
                200,
                ['Content-Type' => 'application/json']
            ),
        ]);

        Livewire::test(SearchDropdown::class)
            ->set('search', 'Rhythm')
            ->assertSee('Rhythm Doctor');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use App\Livewire\MostAnticipated;

class MostAnticipatedTest extends TestCase
{
    public function test_the_most_anticipated_page_shows_correct_games()
    {
        Cache::flush();

        Http::fake([
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            'https://api.igdb.com/v4/games' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/Rhythm Doctor.json')), true),
                200,
                ['Content-Type' => 'application/json']
            ),
        ]);

        Livewire::test(MostAnticipated::class)
            ->call('loadMostAnticipated')
            ->assertSee('Rhythm Doctor');
    }
}

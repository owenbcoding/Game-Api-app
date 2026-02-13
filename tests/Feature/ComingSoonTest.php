<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use App\Livewire\ComingSoon;

class ComingSoonTest extends TestCase
{
    public function test_the_coming_soon_page_shows_correct_games()
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

        Livewire::test(ComingSoon::class)
            ->call('loadComingSoon')
            ->assertSee('Rhythm Doctor');
    }
}

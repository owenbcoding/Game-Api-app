<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ViewGameTest extends TestCase
{
    public function test_the_game_page_shows_correct_game_info()
    {

        Http::fake([
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            'https://api.igdb.com/v4/games' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/Rhythm Doctor.json')), true),
                200,
                ['Content-Type' => 'application/json']
            ),
        ]);

        $response = $this->get(route('games.show', 'rhythm-doctor'));

        $response->assertStatus(200);
        $response->assertSee('Rhythm Doctor');
        $response->assertSee('7th Beat Games');
        $response->assertSee('PC, NS');
        $response->assertSee('Music, Indie');
        $response->assertSee('85.5% member rating');
        $response->assertSee('88.2%');
        $response->assertSee('A rhythm game where you save patients by pressing space on the 7th beat.');
        $response->assertSee('https://www.youtube.com/watch/dQw4w9WgXcQ');
        $response->assertSee('https://rhythmdr.com');
    }
}

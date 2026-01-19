@props([
    // Expected shape: ['slug' => string, 'coverImageUrl' => string, 'rating' => string|int, 'name' => string, 'platforms' => string]
    'game' => [],
])

<div>
    <div class="game mt-8">
        <div class="relative inline-block">
            <a href="{{ route('games.show', $game['slug'] ?? '') }}">
                <img src="{{ $game['coverImageUrl'] }}" alt="game-cover"
                    class="hover:opacity-75 transition ease-in-out duration-150 w-full">
            </a>

            <div class="absolute bottom-2 right-2 w-16 h-16 bg-gray-800 text-white rounded-full flex items-center justify-center"
                style="right: -29px; bottom: -29px;">
                <div class="font-semibold text-xs flex justify-center items-center h-full">
                    {{ $game['rating'] }}
                </div>
            </div>

        </div>
        <a href="{{ route('games.show', $game['slug'] ?? '') }}"
            class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">
            {{ $game['name'] ?? 'Unknown Game' }}
        </a>
        <div class="text-gray-400 mt-1">
            {{ $game['platforms'] }}
        </div>
    </div>
</div>
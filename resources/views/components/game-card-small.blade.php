<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
     <div class="game mt-8">
         <div class="relative inline-block">
            <a href="{{ route('games.show', $game['slug'] ?? '') }}">
                <img
                    src="{{ $game['coverImageUrl'] ?? 'https://via.placeholder.com/264x352' }}"
                    alt="game-cover"
                    class="block w-24 h-24 object-cover rounded hover:opacity-75 transition ease-in-out duration-150"
                >
            </a>
         </div>
         <a href="{{ route('games.show', $game['slug'] ?? '') }}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">
            {{ $game['name'] ?? 'Unknown Game' }}
         </a>
         <div class="text-gray-400 mt-1">
            {{ $game['platforms'] ?? 'Unknown Platform' }}
         </div>
     </div>
</div>
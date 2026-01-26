<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
     <div class="game mt-8">
         <div class="relative inline-block">
            <a href="{{ route('games.show', $game['slug'] ?? '') }}">
                <img
                    src="{{ $game['coverImageUrl'] ?? 'https://via.placeholder.com/264x352' }}"
                    alt="game-cover"
                    class="block w-24 h-36 sm:w-28 sm:h-40 md:w-32 md:h-44 object-cover rounded hover:opacity-75 transition ease-in-out duration-150"
                >
            </a>
            @if (isset($game['rating']))
            <div
                class="absolute bottom-2 right-2 w-10 h-10 bg-gray-800 text-white rounded-full flex items-center justify-center"
                style="right: -14px; bottom: -14px;"
            >
                <div class="font-semibold text-[10px] flex justify-center items-center h-full">
                    {{ $game['rating'] }}
                </div>
            </div>
            @endif
         </div>
         <a href="{{ route('games.show', $game['slug'] ?? '') }}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">
            {{ $game['name'] ?? 'Unknown Game' }}
         </a>
         <div class="text-gray-400 mt-1">
            {{ $game['platforms'] ?? 'Unknown Platform' }}
         </div>
     </div>
</div>
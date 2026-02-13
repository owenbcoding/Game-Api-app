<div>
    <div class="relative" x-data="{ isVisible: true}" @click.away="isVisible = false">
        <input wire:model.live.debounce.300ms="search"
            type="text" class="bg-gray-800 text-sm rounded-full pl-10 pr-3 py-1 w-64" placeholder="Search . . ."
            @focus="isVisible = true">

        <!-- Search Icon -->
        <div class="absolute top-0 flex items-center h-full ml-2">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
            </svg>
        </div>
        <div wire:loading wire:target="search" class="absolute top-0 right-0 mr-4 mt-2">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        @if (strlen($search) >= 2)
            <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-1" x-show="isVisible">
                <ul>
                    @forelse ($searchResults as $game)
                        <li class="border-b border-gray-700 last:border-b-0">
                            <a href="{{ route('games.show', $game['slug'] ?? '') }}" class="block hover:bg-gray-700 flex items-center transition duration-150 ease-in-out px-3 py-3">
                            @if (isset($game['coverImageUrl']))
                                <img src="{{ $game['coverImageUrl'] }}" alt="cover" class="w-8 h-8 rounded object-cover">
                            @else
                                <img src="https://via.placeholder.com/50" alt="cover" class="w-8 h-8 rounded object-cover">
                            @endif
                                <span class="ml-4">{{ $game['name'] ?? 'Unknown Game' }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="px-3 py-3 text-gray-400">No games found.</li>
                    @endforelse
                </ul>
            </div>
        @endif
    </div>
</div>
<div>
    <div class="relative">
        <input wire:model.live.debounce.300ms="search"
            type="text" class="bg-gray-800 text-sm rounded-full pl-10 pr-3 py-1 w-64" placeholder="Search . . .">

        <!-- Search Icon -->
        <div class="absolute top-0 flex items-center h-full ml-2">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
            </svg>
        </div>

        @if (strlen($search) >= 2)
            <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-2">
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
<div wire:init="loadComingSoon">
    @forelse ($comingSoon as $game)
        <div class="comming-soon-container space-y-10 mt-8">
            <div class="game flex">
                <a href="#">
                    <img src="{{ $game['coverImageUrl'] }}" alt="game-cover"
                        class="hover:opacity-75 transition ease-in-out duration-150 w-16">
                </a>
                <div class="ml-4">
                    <a href="#" class="hover:text-gray-300">{{ $game['name'] ?? 'Unknown Game' }}</a>
                    <div class="text-gray-400 text-sm mt-1">
                        {{ carbon\Carbon::parse($game['first_release_date'])->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        @foreach (range(1, 3) as $game)
            <div class="game flex animate-pulse mt-8">
                <div class="bg-gray-800 w-16 h-20 flex-none"></div>
                <div class="ml-4">
                    <div class="text-transparent bg-gray-700 rounded leading-tight">Title
                        goes here</div>
                    <div class="text-transparent bg-gray-700 rounded text-sm mt-1">Sept 14, 2020</div>
                </div>
            </div>
        @endforeach
    @endforelse
</div>

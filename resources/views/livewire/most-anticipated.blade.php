<div wire:init="loadMostAnticipated">
    @forelse ($mostAnticipated as $game)
        <x-game-card-small :game="$game" />
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

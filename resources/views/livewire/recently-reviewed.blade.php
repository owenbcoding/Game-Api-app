    <div wire:init="loadrecentlyReviewed" class="recently-reviews-container space-y-12 mt-8">
        @forelse ($recentlyReviewed as $game)
            <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                <div class="relative flex-none">
                    <a href="#">
                        <img src="{{ $game['coverImageUrl'] }}" alt="game-cover"
                            class="hover:opacity-75 transition ease-in-out duration-150 w-20 lg:w-48">
                    </a>
                    
                        <div
                            data-score-ring
                            data-rating="{{ is_null($game['rating'] ?? null) ? '' : (int) $game['rating'] }}"
                            class="absolute bottom-2 right-2 w-16 h-16 bg-gray-800 text-white rounded-full"
                            style="right: -20px; bottom: -20px;"
                            aria-label="Game rating"
                        >
                            <svg class="w-16 h-16" viewBox="0 0 36 36" aria-hidden="true">
                            <circle
                                    class="text-gray-700"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    fill="transparent"
                                    r="16"
                                    cx="18"
                                    cy="18"
                                />
                                <circle
                                    data-score-ring-progress
                                    class="text-blue-500"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    fill="transparent"
                                    r="16"
                                    cx="18"
                                    cy="18"
                                    stroke-linecap="round"
                                    transform="rotate(-90 18 18)"
                                />
                            </svg>
                            <div
                                data-score-ring-text
                                class="absolute inset-0 font-semibold text-xs flex justify-center items-center"
                            >
                                {{ is_null($game['rating'] ?? null) ? 'N/A' : (int) $game['rating'] }}
                            </div>
                        </div>
                </div>
                <div class="ml-12">
                    <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">
                        {{ $game['name'] ?? 'Unknown Game' }}
                    </a>
                    <div class="text-gray-400 mt-5">
                        {{ $game['platforms'] ?? 'Unknown Platform' }}
                    </div>
                    @if (isset($game['summary']) && is_string($game['summary']))
                        <p class="mt-3 text-gray-400 hidden lg:block">
                            {{ Str::limit($game['summary'], 250) }}
                        </p>
                    @endif
                </div>
            </div>
        @empty
        @foreach (range(1, 3) as $game)
        <div class="game bg-gray-800 animate-pulse rounded-lg shadow-md flex px-6 py-6">
            <div class="relative flex-none">
                <div class="bg-gray-700 w-32 h-56 lg:h-56 lg:w-48"></div>
            </div>
            <div class="ml-6 lg:ml-12">
                <div class="inline-block text-lg font-semibold leading-tight text-transparent bg-gray-700 rounded">Title
                    goes here</div>
                <p class="mt-8 space-y-4 hidden lg:block">
                    <span class="text-transparent bg-gray-700 rounded inline-block">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Lorem, ipsum.</span>
                    <span class="text-transparent bg-gray-700 rounded inline-block">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Lorem, ipsum.</span>
                    <span class="text-transparent bg-gray-700 rounded inline-block">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Lorem, ipsum.</span>
                </p>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>

<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
    <div class="images-container mt-8">
            <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Similar games</h2>
            <div
                class="popular games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 mt-8">
                @if (!empty($similarGames) && is_array($similarGames))
                @foreach ($similarGames as $similarGame)
                <div class="game mt-8">
                    <div class="relative inline-block">
                        <a href="#">
                            <img src="{{ isset($similarGame['cover']['url'])
                                        ? Str::replace('thumb', 'cover_big', $similarGame['cover']['url'])
                                        : asset('images/default-cover.png') }}"
                                alt="game-cover"
                                class="hover:opacity-75 transition ease-in-out duration-150 w-full">
                        </a>

                        @if (isset($similarGame['rating']))
                        <div class="absolute bottom-2 right-2 w-16 h-16 bg-gray-800 text-white rounded-full flex items-center justify-center"
                            style="right: -29px; bottom: -29px;">
                            <div class="font-semibold text-xs flex justify-center items-center h-full">
                                {{ $similarGame['rating'] }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <a href="#"
                        class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">
                        {{ $similarGame['name'] ?? 'Unknown Game' }}
                    </a>
                            <div class="text-gray-400 mt-1">
                                {{ $similarGame['platforms'] ?? 'Unknown Platform' }}
                            </div>
                </div>
                @endforeach
                @else
                <p class="text-gray-400">No similar games available.</p>
                @endif
            </div>
        </div>
</div>
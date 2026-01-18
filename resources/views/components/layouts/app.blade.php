<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game-App</title>
    <link rel="shortcut icon" href="{{ Vite::asset('resources/img/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-900 text-white">
    <header class="border-b border-gray-800">
        <nav class="container mx-auto flex flex-col lg:flex-row max-w-7xl items-center justify-between px-4 py-6">
            <!-- Left Section: Logo & Navigation -->
            <div class="flex flex-col lg:flex-row items-center space-x-8">
                <a href="{{ route('index') }}">
                    <p class="font-bold text-2xl">Game-App</p>
                </a>
                <ul class="flex lg:ml-16 space-x-8 mt-6 lg:mt-0">
                    <li><a href="/games" class="hover:text-gray-400">Games</a></li>
                    <li><a href="/reviews" class="hover:text-gray-400">Reviews</a></li>
                    <li><a href="/coming-soon" class="hover:text-gray-400">Coming Soon</a></li>
                </ul>
            </div>
        
            <!-- Right Section: Search & Avatar -->
            <div class="flex items-center space-x-4 mt-6 lg:mt-0">
                <div class="relative">
                    <input type="text" class="bg-gray-800 text-sm rounded-full pl-10 pr-3 py-1 w-64" placeholder="Search . . .">
                    <!-- Search Icon -->
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <a href="#">
                    <img class="w-10 h-10 rounded-full" src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="avatar">
                </a>
            </div>
        </nav>
    </header>
    <main class="py-8">
        {{ $slot }}
    </main>
    <footer class="border-t border-gray-800">
        <div class="container mx-auto max-w-7xl px-4 py-6">
            Powered by <a href="https://api-docs.igdb.com/" class="underline hover:text-gray-400 " target="_blank">IGDB API</a>
        </div>
    </footer>
    @livewireScripts
</body>
</html>

<x-layouts.app>
    <div class="container mx-auto px-4 max-w-7xl text-center py-16">
        <h1 class="text-4xl font-bold text-gray-300">404</h1>
        <p class="text-xl text-gray-400 mt-4">Page not found.</p>
        <p class="text-gray-500 mt-2">The game or page you're looking for doesn't exist.</p>
        <a href="{{ route('index') }}" class="inline-block mt-8 px-6 py-3 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
            Back to Home
        </a>
    </div>
</x-layouts.app>

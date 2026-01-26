<x-layouts.app>
    <div class="container mx-auto px-4 max-w-7xl">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-5">
            popular games
        </h2>
        <livewire:popular-games />
        <div class="flex flex-col lg:flex-row my-10">
            <div class="recently-viewed w-full  lg:w-3/4 mr-0 lg:mr-32">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">recently viewed</h2>
                <livewire:recently-reviewed />
            </div>
            <div class="most-anticipated w-1/4 lg:w-1/4 mt-12 lg:mt-0">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                <livewire:most-anticipated />

                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-8">Coming Soon</h2>
                <livewire:coming-soon />
            </div>
        </div>
    </div>
</x-layouts.app>
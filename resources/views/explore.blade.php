<x-layout>
<x-post-modal />
    <main class="ml-72 flex-1 mr-96">
                <!-- Categories/Tags Section -->
                <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar">
                    <button class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full text-sm font-medium">
                        All
                    </button>
                    <button class="px-4 py-2 bg-[#161830] rounded-full text-sm font-medium hover:bg-[#1c1f3a] transition-all">
                        Photography
                    </button>
                    <button class="px-4 py-2 bg-[#161830] rounded-full text-sm font-medium hover:bg-[#1c1f3a] transition-all">
                        Art
                    </button>
                    <button class="px-4 py-2 bg-[#161830] rounded-full text-sm font-medium hover:bg-[#1c1f3a] transition-all">
                        Technology
                    </button>
                    <button class="px-4 py-2 bg-[#161830] rounded-full text-sm font-medium hover:bg-[#1c1f3a] transition-all">
                        Travel
                    </button>
                </div>

                <!-- Trending Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Trending Now</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative aspect-[4/3] rounded-xl overflow-hidden group">
                            <img src="https://source.unsplash.com/random/800x600?trending" alt="Trending" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5">
                                        <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                                            <img src="https://source.unsplash.com/random/100x100?portrait" alt="Profile" class="w-full h-full rounded-full object-cover">
                                        </div>
                                    </div>
                                    <span class="font-medium">trending_user</span>
                                </div>
                                <p class="text-sm text-gray-200">Amazing sunset captured in the mountains 🌄 #photography #nature</p>
                            </div>
                        </div>
                        <!-- More trending items -->
                    </div>
                </div>

                <!-- Discover Grid -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Discover</h2>
                    <div class="grid grid-cols-3 gap-4 posts-grid">
                        <!-- Posts will be generated here -->
                    </div>
                </div>
            </main>

            <!-- Right Sidebar -->
            <aside class="w-80 fixed right-4">
                <!-- Popular Tags -->
                <div class="bg-[#161830] rounded-xl p-4 mb-4">
                    <h3 class="font-semibold mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-[#1c1f3a] rounded-full text-sm">#photography</span>
                        <span class="px-3 py-1 bg-[#1c1f3a] rounded-full text-sm">#art</span>
                        <span class="px-3 py-1 bg-[#1c1f3a] rounded-full text-sm">#nature</span>
                        <span class="px-3 py-1 bg-[#1c1f3a] rounded-full text-sm">#travel</span>
                        <span class="px-3 py-1 bg-[#1c1f3a] rounded-full text-sm">#technology</span>
                    </div>
                </div>

                <!-- Trending Creators -->
                <div class="bg-[#161830] rounded-xl p-4">
                    <h3 class="font-semibold mb-4">Trending Creators</h3>
                    <!-- Creator items will be generated here -->
                </div>
            </aside>
        </div>
        <!-- Add this before closing body tag -->
    <div id="loadingIndicator" class="hidden fixed bottom-4 right-4 bg-[#161830] p-2 rounded-lg">
        <div class="loading-spinner w-6 h-6 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>
    @push('scripts')
    @vite('resources/js/index.js')
    @vite('resources/js/explore.js')
    @vite('resources/js/components/fab.js')
    @endpush
</x-layout>
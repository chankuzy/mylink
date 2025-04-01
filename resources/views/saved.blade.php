<x-layout>
<main class="ml-72 flex-1 mr-96">
            <!-- Collections Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Saved Posts</h2>
                <button class="px-4 py-2 bg-[#161830] rounded-lg text-sm hover:bg-[#1c1f3a] transition-all">
                    <i class="ri-add-line mr-1"></i> New Collection
                </button>
            </div>

            <!-- Collections Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <!-- All Saved -->
                <div class="bg-[#161830] rounded-xl p-4 cursor-pointer hover:bg-[#1c1f3a] transition-all">
                    <div class="grid grid-cols-2 gap-1 mb-3">
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza1.jpeg" alt="Saved" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza2.jpeg" alt="Saved" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza1.jpeg" alt="Saved" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza2.jpeg" alt="Saved" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="font-medium">All Saved</h3>
                    <p class="text-sm text-gray-400">248 posts</p>
                </div>

                <!-- Inspiration -->
                <div class="bg-[#161830] rounded-xl p-4 cursor-pointer hover:bg-[#1c1f3a] transition-all">
                    <div class="grid grid-cols-2 gap-1 mb-3">
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza2.jpeg" alt="Inspiration" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza1.jpeg" alt="Inspiration" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza2.jpeg" alt="Inspiration" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <img src="akaza1.jpeg" alt="Inspiration" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="font-medium">Inspiration</h3>
                    <p class="text-sm text-gray-400">124 posts</p>
                </div>
            </div>

            <!-- Recent Saves -->
            <div class="bg-[#161830] rounded-xl p-6">
                <h3 class="font-semibold mb-4">Recent Saves</h3>
                <div class="grid grid-cols-3 gap-4" id="recentSaves">
                    <!-- Posts will be generated here -->
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="w-80 fixed right-4">
            <!-- Collection Stats -->
            <div class="bg-[#161830] rounded-xl p-4 mb-4">
                <h3 class="font-semibold mb-4">Collection Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Total saved</span>
                        <span class="font-medium">248</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Collections</span>
                        <span class="font-medium">5</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Last saved</span>
                        <span class="text-sm text-gray-400">2 hours ago</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#161830] rounded-xl p-4">
                <h3 class="font-semibold mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <button class="w-full p-3 text-left rounded-lg hover:bg-[#1c1f3a] transition-all flex items-center gap-3">
                        <i class="ri-add-line"></i>
                        Create collection
                    </button>
                    <button class="w-full p-3 text-left rounded-lg hover:bg-[#1c1f3a] transition-all flex items-center gap-3">
                        <i class="ri-folder-transfer-line"></i>
                        Organize saves
                    </button>
                    <button class="w-full p-3 text-left rounded-lg hover:bg-[#1c1f3a] transition-all flex items-center gap-3">
                        <i class="ri-share-line"></i>
                        Share collection
                    </button>
                </div>
            </div>
        </aside>
    </div>
    @push('scripts')
    @vite('resources/js/index.js')
    @vite('resources/js/saved.js')
    @endpush
</x-layout>
<nav class="fixed w-full bg-[#0f1025]/80 backdrop-blur-xl z-50 py-2 border-b border-white/10">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between gap-8">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                Nexus
            </h1>
            
            <div class="flex-1 max-w-xl">
                <div class="relative group">
                    <i class="ri-search-line absolute left-4 top-3 text-gray-400 group-focus-within:text-purple-500"></i>
                    <input type="text" 
                           placeholder="Discover something amazing..." 
                           class="w-full bg-[#161830] rounded-xl py-2.5 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="p-2.5 hover:bg-[#161830] rounded-xl transition-colors flex items-center gap-2">
                        <i class="ri-add-line text-xl"></i>
                        <span class="text-sm font-medium">Create</span>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-[#161830] rounded-xl shadow-lg py-2 border border-white/10">
                        <button id="create" class="flex items-center gap-3 px-4 py-3 hover:bg-[#1c1f3a] transition-colors"> 
                            <i class="ri-image-add-line text-purple-500"></i>
                            <div>
                                <div class="font-medium">Create Post</div>
                                <div class="text-xs text-gray-400">Share photos and videos</div>
                            </div>
                        </button>
                        <a href="{{ route('create-story') }}" 
                           class="flex items-center gap-3 px-4 py-3 hover:bg-[#1c1f3a] transition-colors">
                            <i class="ri-story-line text-blue-500"></i>
                            <div>
                                <div class="font-medium">Create Story</div>
                                <div class="text-xs text-gray-400">Share moments that disappear</div>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('notifications') }}" class="p-2.5 hover:bg-[#161830] rounded-xl transition-colors relative">
                    <i class="ri-notification-3-line text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center">
                        3
                    </span>
                </a>

                <x-user-dropdown />
            </div>
        </div>
    </div>
</nav>
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center gap-2 p-1.5 hover:bg-[#161830] rounded-xl transition-colors">
        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" class="w-8 h-8 rounded-full object-cover">
        @else
            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center">
                <span class="text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        @endif
        <i class="ri-arrow-down-s-line"></i>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition
         class="absolute right-0 mt-2 w-64 bg-[#161830] rounded-xl shadow-lg py-2 border border-white/10">
        
        <div class="px-4 py-3 border-b border-white/10">
            <div class="font-medium">{{ auth()->user()->name }}</div>
            <div class="text-sm text-gray-400">{{ '@' . auth()->user()->username }}</div>
        </div>

        <div class="py-2">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-[#1c1f3a] transition-colors">
                <i class="ri-user-line text-lg"></i>
                <span>Profile</span>
            </a>
            
            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-[#1c1f3a] transition-colors">
                <i class="ri-settings-4-line text-lg"></i>
                <span>Settings</span>
            </a>

            <a href="{{ route('saved') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-[#1c1f3a] transition-colors">
                <i class="ri-bookmark-line text-lg"></i>
                <span>Saved Posts</span>
            </a>
        </div>

        <div class="border-t border-white/10 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-[#1c1f3a] transition-colors text-red-500">
                    <i class="ri-logout-box-r-line text-lg"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>
</div>
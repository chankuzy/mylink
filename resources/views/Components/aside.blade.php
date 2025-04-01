<aside class="w-64 fixed left-4">
    <div class="space-y-2">
        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
            <i class="ri-home-5-line text-xl"></i>
            <span>Home</span>
        </x-nav-link>
        <x-nav-link href="{{ route('explore') }}" :active="request()->routeIs('explore')">
            <i class="ri-compass-3-line text-xl"></i>
            <span>Explore</span>
        </x-nav-link>
        <x-nav-link href="{{ route('chat') }}" :active="request()->routeIs('chat')">
            <i class="ri-message-3-line text-xl"></i>
            <span>Chat</span>
        </x-nav-link>
        <x-nav-link href="{{ route('saved') }}" :active="request()->routeIs('saved')">
            <i class="ri-bookmark-line text-xl"></i>
            <span>Saved</span>
        </x-nav-link>
    </div>
</aside>
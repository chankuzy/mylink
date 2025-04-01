@props(['story'])

<div class="story-item flex flex-col items-center cursor-pointer">
    <div class="w-16 h-16 rounded-full p-0.5 bg-gradient-to-br from-purple-500 to-blue-500">
        <div class="bg-[#0a0b1e] p-0.5 rounded-full">
            <img src="{{ Vite::asset('resources/images/akaza2.jpeg') }}"
                 alt="{{ $story['user']['username'] }}'s story"
                 class="w-14 h-14 rounded-full object-cover">
        </div>
    </div>
    <span class="text-sm mt-1">{{ $story['user']['username'] }}</span>
</div>
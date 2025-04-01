<x-layout>
<x-post-modal />
<main class="ml-72 flex-1">
    <!-- Stories Section -->
    <div class="flex gap-4 overflow-x-auto pb-4 ">
        <!-- Your Story item -->
        <div class="story-item flex flex-col items-center cursor-pointer">
            <a href="{{ route('create-story') }}" class="w-16 h-16 rounded-full p-0.5 bg-gradient-to-br from-purple-500 to-blue-500">
                <div class="bg-[#0a0b1e] p-0.5 rounded-full">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="w-14 h-14 rounded-full object-cover">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center">
                            <i class="ri-add-line text-2xl"></i>
                        </div>
                    @endif
                </div>
            </a>
            <span class="text-sm mt-1">Your Story</span>
        </div>

        @if(isset($stories) && count($stories) > 0)
            @foreach($stories as $story)
                <x-story-item :story="$story" />
            @endforeach
        @endif
    </div>

    <!-- Fix the posts container structure -->
    <div class="posts-container space-y-6 mt-8 max-w-[600px]">
        @foreach($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach
    </div>
    
    <div id="skeleton-container" class="hidden space-y-6 mt-8 max-w-[600px]">
        @for($i = 0; $i < 3; $i++)
            <x-post-skeleton />
        @endfor
    </div>
    
</main>

<!-- Right Sidebar -->
<aside class="w-80 fixed right-4">
    <div class="flex items-center gap-4 mb-6">
        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" class="w-12 h-12 rounded-full object-cover">
        @else
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center">
                <span class="text-lg font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        @endif
        <div>
            <p class="font-semibold">{{ auth()->user()->username }}</p>
            <p class="text-gray-400 text-sm">{{ auth()->user()->name }}</p>
        </div>
    </div>

    <!-- Suggestions -->
    <div class="bg-[#161830] rounded-xl p-4">
        <h3 class="font-semibold mb-4">Suggested for you</h3>
        <div class="space-y-4">
            @foreach($suggestions as $user)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-sm font-semibold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-medium">{{ $user->username }}</p>
                            <p class="text-sm text-gray-400">Suggested for you</p>
                        </div>
                    </div>
                    <button class="follow-button text-blue-500 text-sm font-medium hover:text-blue-400"
                            data-user-id="{{ $user->id }}">
                        Follow
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</aside>

@push('scripts')
@vite('resources/js/components/fab.js')
@vite('resources/js/components/post.js')
@vite('resources/js/components/comments.js')
@endpush
</x-layout>
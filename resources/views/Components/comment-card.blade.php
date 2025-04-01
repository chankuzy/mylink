<div class="flex gap-3 p-3 rounded-xl bg-[#1c1f3a]" data-comment-id="{{ $comment->id }}">
    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 shrink-0">
        <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
            @if($comment->user->avatar)
                <img src="{{ $comment->user->avatar }}" class="w-full h-full rounded-full object-cover">
            @else
                <div class="w-full h-full rounded-full bg-gray-600 flex items-center justify-center">
                    <span class="text-xs font-semibold">{{ substr($comment->user->name, 0, 1) }}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
            <span class="font-semibold">{{ $comment->user->name }}</span>
            <span class="text-sm text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <p class="text-sm text-gray-200">{{ $comment->content }}</p>
        <div class="mt-2 flex items-center gap-4">
            <button class="like-comment-btn flex items-center gap-1.5 text-sm text-gray-400 hover:text-purple-500 transition-colors {{ $comment->isLikedBy(auth()->user()) ? 'text-purple-500' : '' }}">
                <i class="ri-heart-3-{{ $comment->isLikedBy(auth()->user()) ? 'fill' : 'line' }} text-lg"></i>
                <span class="likes-count">{{ $comment->likes_count }}</span>
            </button>
            <button class="reply-btn flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-500 transition-colors">
                <i class="ri-chat-1-line text-lg"></i>
                <span>Reply</span>
            </button>
        </div>

        <!-- Reply Form (Hidden by default) -->
        <div class="reply-form-container hidden mt-3">
            <form class="reply-form" data-parent-id="{{ $comment->id }}" data-post-id="{{ $comment->post_id }}">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 shrink-0">
                        <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-600 flex items-center justify-center">
                                    <span class="text-[10px] font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 relative">
                        <input type="text" 
                            class="w-full bg-[#1c1f3a] rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-purple-500"
                            placeholder="Write a reply..."
                            name="content">
                        <button type="submit" 
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-purple-500 hover:bg-purple-600 transition-all duration-200 px-3 py-1 rounded-lg text-xs">
                            Reply
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Replies Container -->
        @if($comment->replies_count > 0)
            <div class="replies-container mt-3 space-y-3 pl-4 border-l border-gray-700">
                @foreach($comment->replies as $reply)
                    @include('components.comment-card', ['comment' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>
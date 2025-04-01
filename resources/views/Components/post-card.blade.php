@props(['post'])

<div class="post-card bg-[#161830] rounded-xl overflow-hidden hover:bg-[#1c1f3a] transition-colors" data-initialized="false">
    <!-- Header with User Info -->
    <div class="p-4">
        <div class="flex gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 shrink-0">
                <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                    @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->username }}" 
                             class="w-full h-full rounded-full object-cover cursor-pointer">
                    @else
                        <div class="w-full h-full rounded-full cursor-pointer bg-gray-600 flex items-center justify-center">
                            <span class="text-sm font-semibold">{{ substr($post->user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <a href="{{ '/profile/' . $post->user->username }}" class="cursor-pointer font-bold hover:underline">{{ $post->user->username }}</a>
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    <button class="text-gray-400 hover:text-white ml-auto">
                        <i class="ri-more-fill"></i>
                    </button>
                </div>

                <!-- Post Content -->
                @if($post->content)
                    <p class="mt-2 text-[15px] leading-normal">{{ $post->content }}</p>
                @endif

                <!-- Media -->
                @if($post->media)
                    <div class="mt-3 rounded-xl overflow-hidden border border-gray-700">
                        <img src="{{ asset('storage/' . $post->media) }}" 
                             alt="Post by {{ $post->user->username }}" 
                             class="w-full object-cover">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Buttons with enhanced interactions -->
    <!-- Action Buttons section -->
    <div class="px-4 pb-4 flex items-center gap-6">
        <button class="cursor-pointer like-button group flex items-center gap-2 text-gray-400 hover:text-purple-500 relative"
                data-post-id="{{ $post->id }}"
                data-liked="{{ $post->liked_by_user ? 'true' : 'false' }}">
            <div class="p-2 rounded-full group-hover:bg-purple-500/10 relative">
                <i class="ri-heart-{{ $post->liked_by_user ? 'fill text-purple-500' : 'line' }} text-lg transition-all duration-300"></i>
                <div class="like-animation absolute inset-0 flex items-center justify-center opacity-0 scale-0">
                    <i class="ri-heart-fill text-purple-500 text-4xl"></i>
                </div>
            </div>
            <span class="likes-count transition-all duration-300">{{ $post->likes_count }}</span>
        </button>

        <a href="{{ route('posts.show', $post) }}" class="cursor-pointer comment-button group flex items-center gap-2 text-gray-400 hover:text-blue-500">
            <div class="p-2 rounded-full group-hover:bg-blue-500/10">
                <i class="ri-chat-1-line text-lg transition-all duration-300"></i>
            </div>
            <span class="text-sm transition-all duration-300">{{ $post->comments_count }}</span>
        </a>

        <button class="share-button group flex items-center gap-2 text-gray-400 hover:text-green-500">
            <div class="p-2 rounded-full group-hover:bg-green-500/10">
                <i class="ri-repeat-line text-lg transition-all duration-300"></i>
            </div>
        </button>

        <button class="bookmark-button group flex items-center gap-2 text-gray-400 hover:text-blue-500 ml-auto">
            <div class="p-2 rounded-full group-hover:bg-blue-500/10">
                <i class="ri-bookmark-line text-lg transition-all duration-300"></i>
            </div>
        </button>
    </div>

    <!-- Add styles -->
    <style>
        .like-animation.active {
            animation: likeAnimation 0.4s ease;
        }

        @keyframes likeAnimation {
            0% {
                opacity: 0;
                transform: scale(0);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
            100% {
                opacity: 0;
                transform: scale(1);
            }
        }

        .post-card {
            transition: transform 0.2s ease;
        }
    </style>

    <!-- Comments Section -->
    <div class="px-4 pb-4">
        <!-- Comment Count & View All -->
        <div class="flex items-center justify-between mb-3">
            <a href="{{ route('posts.show', $post) }}" class="text-sm text-gray-400 hover:text-white">
                View all <span class="comments-count">{{ $post->comments_count }}</span> comments
            </a>
            <button class="text-sm text-gray-400 hover:text-white sort-comments-btn">
                <i class="ri-time-line mr-1"></i> Most Recent
            </button>
        </div>

        <!-- Only show comment input if not on the dedicated post page -->
        @if(!isset($showFullComments))
        <div class="flex items-center gap-2 mt-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 shrink-0">
                <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <div class="w-full h-full rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-xs font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <form class="flex-1 comment-form" id="comment-form" data-post-id="{{ $post->id }}">
                <div class="relative">
                    <input type="text" 
                           class="w-full bg-[#1c1f3a] rounded-full py-2 pl-4 pr-12 text-sm focus:outline-none focus:ring-1 focus:ring-purple-500"
                           placeholder="Add a comment..."
                           name="content">
                    <button type="submit" 
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-purple-500 opacity-0 transition-opacity duration-200">
                        <i class="ri-send-plane-fill"></i>
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
    <script>

            (() => {
            // Like functionality
            document.addEventListener('click', async (e) => {
                const likeButton = e.target.closest('.like-button');

                if (!likeButton || !likeButton.dataset.postId || likeButton.disabled) return;

                e.preventDefault();

                const postId = likeButton.dataset.postId;
                const icon = likeButton.querySelector('i');
                const countEl = likeButton.querySelector('.likes-count');
                const animation = likeButton.querySelector('.like-animation');

                likeButton.disabled = true;

                try {
                    const response = await fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        likeButton.dataset.liked = data.action === 'liked' ? 'true' : 'false';
                        icon.className = data.action === 'liked'
                            ? 'ri-heart-fill text-purple-500 text-lg transition-all duration-300'
                            : 'ri-heart-line text-lg transition-all duration-300';

                        countEl.textContent = data.likes_count;

                        if (data.action === 'liked') {
                            animation.classList.add('active');
                            setTimeout(() => animation.classList.remove('active'), 400);
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Failed to update like', 'error');
                } finally {
                    setTimeout(() => { likeButton.disabled = false; }, 200);
                }
            });

            // Comment functionality
            document.addEventListener('submit', async (e) => {
                const commentForm = e.target.closest('.comment-form');

                if (commentForm && commentForm.dataset.postId) {
                    e.preventDefault();
                    e.stopImmediatePropagation(); // Prevent multiple event triggers

                    const submitButton = commentForm.querySelector('button[type="submit"]');
                    const input = commentForm.querySelector('input[name="content"]');
                    const content = input.value.trim();
                    const postId = commentForm.dataset.postId;

                    if (!content) {
                        showToast('Please write a comment first', 'error');
                        return;
                    }

                    submitButton.disabled = true;
                    input.disabled = true;

                    try {
                        const response = await fetch(`/posts/${postId}/comment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ content })
                        });

                        const data = await response.json();

                        if (data.success) {
                            input.value = '';

                            document.querySelectorAll(`.comments-count[data-post-id="${postId}"]`).forEach(el => {
                                el.textContent = parseInt(el.textContent) + 1;
                            });

                            showToast('Comment posted successfully! 💬', 'success');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Failed to post comment', 'error');
                    } finally {
                        submitButton.disabled = false;
                        input.disabled = false;
                    }
                }
            });

            // Show submit button only when input has content
            document.addEventListener('input', (e) => {
                const input = e.target.closest('.comment-form input[name="content"]');
                if (input) {
                    const submitButton = input.closest('.comment-form').querySelector('button[type="submit"]');
                    submitButton.style.opacity = input.value.trim() ? '1' : '0';
                }
            });

        })();

        // Toast function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 left-1/2 -translate-x-1/2 px-6 py-3 rounded-full shadow-lg transition-all duration-300 -translate-y-full z-50 ${
                type === 'success' ? 'bg-[#1d9bf0] text-white' : 'bg-red-500 text-white'
            }`;

            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => toast.classList.remove('-translate-y-full'), 100);

            setTimeout(() => {
                toast.classList.add('-translate-y-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

    </script>

</div>


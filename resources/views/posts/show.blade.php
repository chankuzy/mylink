<x-layout>
    <div class="mx-auto w-lg max-w-lg flex flex-col">
        <!-- Post Content -->
        <div class="mb-6">
            @include('components.post-card', ['post' => $post, 'showFullComments' => true])
        </div>

        <!-- Comments Section -->
        <div class="bg-[#161830] rounded-xl p-4 mt-6">
            <h2 class="text-lg font-semibold mb-4">Comments</h2>
            
            <!-- Comment Input -->
            <div class="mb-6">
                <form class="comment-form" id="comment-form" data-post-id="{{ $post->id }}">
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 shrink-0">
                            <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 relative">
                            <input type="text" 
                                class="w-full bg-[#1c1f3a] rounded-xl px-4 py-3 focus:outline-none focus:ring-1 focus:ring-purple-500"
                                placeholder="Write a comment..."
                                name="content">
                                <button type="submit" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-purple-500 hover:bg-purple-600 transition-all duration-200 px-4 py-1.5 rounded-lg text-sm flex items-center gap-2 group">
                                    <span>Post</span>
                                    <i class="ri-send-plane-fill group-hover:translate-x-1 transition-transform duration-200"></i>
                                </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div id="comments-container" class="space-y-4">
                @foreach($userComments as $comment)
                    @include('components.comment-card', ['comment' => $comment])
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('comment-form');
            
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const postId = form.dataset.postId;
                const input = form.querySelector('input');
                const submitBtn = form.querySelector('button[type="submit"]');
                const content = input.value.trim();
                
                if (!content) {
                    showToast('Please write a comment first', 'error');
                    return;
                }
                
                submitBtn.disabled = true;
                input.disabled = true;
                
                try {
                    const response = await fetch(`/posts/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ content })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        const commentsContainer = document.getElementById('comments-container');
                        commentsContainer.insertAdjacentHTML('afterbegin', data.html);
                        input.value = '';
                        
                        // Update comment count
                        const countElements = document.querySelectorAll('.comments-count');
                        countElements.forEach(el => {
                            const newCount = parseInt(el.textContent) + 1;
                            el.textContent = newCount;
                        });

                        showToast('Comment posted successfully! 💬', 'success');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Failed to post comment. Please try again.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    input.disabled = false;
                }
            });
        });

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 left-1/2 -translate-x-1/2 px-6 py-3 rounded-full shadow-lg transform transition-all duration-300 -translate-y-full z-50
                ${type === 'success' ? 'bg-[#1d9bf0] text-white' : 'bg-red-500 text-white'}`;
            toast.innerHTML = message;
            document.body.appendChild(toast);
            
            // Slide down
            setTimeout(() => toast.classList.remove('-translate-y-full'), 100);
            
            // Slide up and remove
            setTimeout(() => {
                toast.classList.add('-translate-y-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Initialize like buttons
        document.addEventListener('click', async (e) => {
            if (e.target.closest('.like-comment-btn')) {
                const btn = e.target.closest('.like-comment-btn');
                const commentEl = btn.closest('[data-comment-id]');
                const commentId = commentEl.dataset.commentId;
                const icon = btn.querySelector('i');
                const countEl = btn.querySelector('.likes-count');
                
                try {
                    const response = await fetch(`/comments/${commentId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        // Update like count
                        countEl.textContent = data.likes_count;
                        
                        // Toggle like state
                        if (data.is_liked) {
                            btn.classList.add('text-purple-500');
                            icon.classList.replace('ri-heart-3-line', 'ri-heart-3-fill');
                        } else {
                            btn.classList.remove('text-purple-500');
                            icon.classList.replace('ri-heart-3-fill', 'ri-heart-3-line');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Failed to update like', 'error');
                }
            }
        });
    </script>
    @endpush
</x-layout>
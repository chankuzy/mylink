import { showToast } from './toast';

export function initializePosts() {
    // Initialize all posts on the page
    const posts = document.querySelectorAll('.post-card');
    posts.forEach(initializePostInteractions);

    // Initialize infinite scroll
    const postsContainer = document.querySelector('.posts-container');
    const skeletonContainer = document.getElementById('skeleton-container');
    
    if (postsContainer && skeletonContainer) {
        initializeInfiniteScroll(postsContainer, skeletonContainer);
    }
}

function initializePostInteractions(postCard) {
    // Like functionality
    const likeButton = postCard.querySelector('.like-button');
    const postId = likeButton?.dataset.postId;
    
    if (likeButton && postId) {
        likeButton.addEventListener('click', async (e) => {
            e.preventDefault();
            if (likeButton.disabled) return;

            likeButton.disabled = true;
            const icon = likeButton.querySelector('i');
            const countEl = likeButton.querySelector('.likes-count');
            const animation = likeButton.querySelector('.like-animation');

            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    if (data.action === 'liked') {
                        icon.className = 'ri-heart-fill text-purple-500 text-lg transition-all duration-300';
                        animation.classList.add('active');
                    } else {
                        icon.className = 'ri-heart-line text-lg transition-all duration-300';
                    }
                    countEl.textContent = data.likes_count;
                    likeButton.dataset.liked = data.action === 'liked' ? 'true' : 'false';

                    setTimeout(() => {
                        animation.classList.remove('active');
                    }, 400);
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to update like', 'error');
            } finally {
                setTimeout(() => {
                    likeButton.disabled = false;
                }, 200);
            }
        });
    }

    // Comment functionality
    const commentForm = postCard.querySelector('.comment-form');
    if (commentForm) {
        const input = commentForm.querySelector('input[name="content"]');
        const submitButton = commentForm.querySelector('button[type="submit"]');

        input.addEventListener('input', () => {
            submitButton.style.opacity = input.value.trim() ? '1' : '0';
        });

        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopPropagation();

            const content = input.value.trim();
            if (!content) return;

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
                    submitButton.style.opacity = '0';
                    
                    // Update all comment counts for this post
                    const commentCounts = postCard.querySelectorAll('.comments-count');
                    commentCounts.forEach(count => {
                        count.textContent = parseInt(count.textContent) + 1;
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
        });
    }
}

function initializeInfiniteScroll(postsContainer, skeletonContainer) {
    let page = 1;
    let loading = false;
    let hasMore = true;

    const observer = new IntersectionObserver((entries) => {
        const target = entries[0];
        if (target.isIntersecting && !loading && hasMore) {
            loadMorePosts();
        }
    }, {
        rootMargin: '50px'
    });

    observer.observe(skeletonContainer);

    async function loadMorePosts() {
        if (loading || !hasMore) return;
        
        try {
            loading = true;
            skeletonContainer.style.display = 'block';

            const response = await fetch(`/posts?page=${page + 1}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            
            if (data.html) {
                postsContainer.insertAdjacentHTML('beforeend', data.html);
                page++;
                hasMore = data.hasMore;

                // Initialize new posts
                const newPosts = postsContainer.querySelectorAll('.post-card:not([data-initialized])');
                newPosts.forEach(post => {
                    initializePostInteractions(post);
                    post.setAttribute('data-initialized', 'true');
                });
            }
            
            if (!hasMore) {
                skeletonContainer.style.display = 'none';
                observer.disconnect();
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Failed to load more posts', 'error');
        } finally {
            loading = false;
            skeletonContainer.style.display = hasMore ? 'block' : 'none';
        }
    }
}

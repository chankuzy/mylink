import { showToast } from './toast';

export function initializeComments() {
    document.addEventListener('click', (e) => {
        // Handle reply button clicks
        if (e.target.matches('.reply-button')) {
            const commentId = e.target.dataset.commentId;
            const commentItem = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
            const replyForm = commentItem.querySelector('.reply-form');
            
            // Hide all other reply forms
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form !== replyForm) form.classList.add('hidden');
            });
            
            replyForm.classList.toggle('hidden');
            replyForm.querySelector('input').focus();
        }
    });

    // Handle reply form submissions
    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const input = form.querySelector('input');
            const content = input.value.trim();
            const parentId = form.dataset.parentId;
            const postId = form.closest('.post-card').querySelector('.like-button').dataset.postId;

            if (!content) return;

            try {
                const response = await fetch(`/posts/${postId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ content, parent_id: parentId })
                });

                const data = await response.json();

                if (data.success) {
                    // Insert the new comment HTML
                    const parentComment = form.closest('.comment-item');
                    let repliesContainer = parentComment.querySelector('.replies-container');
                    
                    if (!repliesContainer) {
                        repliesContainer = document.createElement('div');
                        repliesContainer.className = 'replies-container mt-2';
                        parentComment.appendChild(repliesContainer);
                    }

                    repliesContainer.insertAdjacentHTML('beforeend', data.html);
                    
                    // Clear and hide the form
                    input.value = '';
                    form.classList.add('hidden');
                    
                    // Update comment count
                    const commentCounts = document.querySelectorAll('.comments-count');
                    commentCounts.forEach(count => {
                        count.textContent = parseInt(count.textContent) + 1;
                    });

                    showToast('Reply posted successfully! 💬', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to post reply', 'error');
            }
        });
    });

    // Handle comment deletion
    document.querySelectorAll('.delete-comment').forEach(button => {
        button.addEventListener('click', async () => {
            if (!confirm('Are you sure you want to delete this comment?')) return;

            const commentItem = button.closest('.comment-item');
            const commentId = commentItem.dataset.commentId;

            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    commentItem.remove();
                    showToast('Comment deleted successfully', 'success');
                    
                    // Update comment count
                    const commentCounts = document.querySelectorAll('.comments-count');
                    commentCounts.forEach(count => {
                        count.textContent = Math.max(0, parseInt(count.textContent) - 1);
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to delete comment', 'error');
            }
        });
    });
}
export function handlePostSubmit(form) {
    const formData = new FormData(form);
    
    fetch('/posts', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add new post to feed without reload
            const postsContainer = document.querySelector('.posts-feed');
            postsContainer.insertAdjacentHTML('afterbegin', data.html);
            
            // Close modal and reset form
            window.Alpine.store('modal', { open: false });
            form.reset();
        }
    })
    .catch(error => console.error('Error:', error));
}
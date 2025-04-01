// Initialize Alpine.js first
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

// Then import bootstrap and other dependencies
import './bootstrap';

import './index';
import './notifications';
import './profile';
import './saved';

// Import reusable components
import { createSkeleton } from './components/skeleton';
import { initializeComments } from './components/comments';
import { initializeFloatingButton } from './components/fab';
import { initializeFormValidation } from './components/form-validation';
import { optimizeImage } from './components/image-optimizer';
import { initializePosts } from './components/post';
import { initializeStorySlider } from './components/stories';
import { initializeTheme } from './components/theme';
import { showToast } from './components/toast';

document.addEventListener('DOMContentLoaded', () => {
    // Make Alpine available globally for components
    window.Alpine = Alpine;
    
    // Initialize theme first to prevent flash of unstyled content
    initializeTheme();

    // Initialize floating action button on appropriate pages
    if (document.querySelector('[data-show-fab="true"]')) {
        initializeFloatingButton();
    }

    // Show welcome toast if needed
    if (document.querySelector('[data-show-welcome="true"]')) {
        showToast('Welcome to Clink! 👋');
    }
    
    // Initialize posts if we're on a page with posts
    if (document.querySelector('.posts-container')) {
        initializePosts();
    }
    
    // Initialize comments if we're on a page with posts
    if (document.querySelector('.posts-container')) {
        // Initialize comments on all pages
        import { initializeComments } from './components/comments';
        
        document.addEventListener('DOMContentLoaded', () => {
            initializeComments();
        });
    }
});

// Export components for use in other files if needed
export {
    createSkeleton,
    optimizeImage,
    showToast
};

document.addEventListener('DOMContentLoaded', function() {
    let page = 1;
    let loading = false;
    const container = document.querySelector('#posts-container');

    if (!container) return;

    window.addEventListener('scroll', function() {
        if (loading) return;

        if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 100) {
            loading = true;
            page++;

            fetch(`/?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    container.insertAdjacentHTML('beforeend', data.html);
                }
                if (!data.hasMore) {
                    window.removeEventListener('scroll', this);
                }
                loading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                loading = false;
            });
        }
    });
});
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
    const postsContainer = document.querySelector('#posts-container');
    if (postsContainer) {
        initializePosts();
    }
    
    // Initialize comments
    if (postsContainer) {
        initializeComments();
    }
});

// Export components
export {
    createSkeleton,
    optimizeImage,
    showToast
};
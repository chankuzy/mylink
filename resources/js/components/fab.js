export function initializeFloatingButton() {
    const fab = document.createElement('button');
    fab.className = 'fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full shadow-lg flex items-center justify-center hover:scale-110 transition-transform z-50 group';
    fab.innerHTML = `
        <i class="ri-add-line text-2xl"></i>
        <span class="absolute right-16 bg-[#161830] px-3 py-1 rounded-lg text-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Create Post</span>
    `;
    
    fab.addEventListener('click', () => {
        // Try both methods to ensure compatibility
        if (window.Alpine) {
            const modal = document.querySelector('[x-data]');
            if (modal && modal.__x) {
                modal.__x.data.open = true;
            }
        }
        if (typeof window.openPostModal === 'function') {
            window.openPostModal();
        }
    });
    
    document.body.appendChild(fab);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initializeFloatingButton();
});

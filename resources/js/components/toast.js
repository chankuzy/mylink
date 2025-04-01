export function showToast(message, type = 'success') {
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
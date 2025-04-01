document.addEventListener('DOMContentLoaded', () => {
    initializeRecentSaves();
    initializeCollectionCreation();
    initializeCollectionSharing();
    initializeOrganizer();
    updateStats();
});

function initializeRecentSaves() {
    const recentSaves = document.getElementById('recentSaves');
    const savedPosts = [
        { image: 'akaza1.jpeg', likes: '2.4K', comments: '128' },
        { image: 'akaza2.jpeg', likes: '1.8K', comments: '96' },
        { image: 'akaza1.jpeg', likes: '3.1K', comments: '245' },
        { image: 'akaza2.jpeg', likes: '982', comments: '67' },
        { image: 'akaza1.jpeg', likes: '1.5K', comments: '154' },
        { image: 'akaza2.jpeg', likes: '2.7K', comments: '189' }
    ];

    savedPosts.forEach(post => {
        const div = document.createElement('div');
        div.className = 'relative group';
        div.innerHTML = `
            <div class="aspect-square rounded-xl overflow-hidden">
                <img src="${post.image}" alt="Saved post" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                    <div class="flex items-center gap-1">
                        <i class="ri-heart-fill"></i>
                        <span>${post.likes}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="ri-chat-1-fill"></i>
                        <span>${post.comments}</span>
                    </div>
                </div>
            </div>
        `;
        recentSaves.appendChild(div);
    });
}

function initializeCollectionCreation() {
    const createButtons = document.querySelectorAll('button:has(.ri-add-line)');
    createButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-[#161830] rounded-xl p-6 w-96">
                    <h3 class="text-xl font-semibold mb-4">Create Collection</h3>
                    <input type="text" 
                           placeholder="Collection name" 
                           class="w-full bg-[#1c1f3a] rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <textarea placeholder="Description (optional)" 
                              class="w-full bg-[#1c1f3a] rounded-lg px-4 py-2 mb-4 h-24 resize-none focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    <div class="flex justify-end gap-3">
                        <button class="px-4 py-2 rounded-lg hover:bg-[#1c1f3a] transition-all" onclick="this.closest('.fixed').remove()">
                            Cancel
                        </button>
                        <button class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg">
                            Create
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        });
    });
}

function initializeCollectionSharing() {
    const shareButton = document.querySelector('button:has(.ri-share-line)');
    shareButton.addEventListener('click', () => {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-[#161830] rounded-xl p-6 w-96">
                <h3 class="text-xl font-semibold mb-4">Share Collection</h3>
                <div class="space-y-4">
                    <button class="w-full p-3 bg-[#1c1f3a] rounded-lg flex items-center gap-3 hover:bg-[#232744] transition-all">
                        <i class="ri-link-m"></i>
                        Copy link
                    </button>
                    <button class="w-full p-3 bg-[#1c1f3a] rounded-lg flex items-center gap-3 hover:bg-[#232744] transition-all">
                        <i class="ri-twitter-fill"></i>
                        Share on Twitter
                    </button>
                    <button class="w-full p-3 bg-[#1c1f3a] rounded-lg flex items-center gap-3 hover:bg-[#232744] transition-all">
                        <i class="ri-facebook-circle-fill"></i>
                        Share on Facebook
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    });
}

function initializeOrganizer() {
    const organizeButton = document.querySelector('button:has(.ri-folder-transfer-line)');
    organizeButton.addEventListener('click', () => {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-[#161830] rounded-xl p-6 w-[800px]">
                <h3 class="text-xl font-semibold mb-4">Organize Saves</h3>
                <div class="grid grid-cols-3 gap-4 max-h-[600px] overflow-y-auto">
                    <!-- Posts will be generated here -->
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        generateOrganizePosts(modal.querySelector('.grid'));
    });
}

function generateOrganizePosts(container) {
    const posts = Array(15).fill().map((_, i) => ({
        image: i % 2 === 0 ? 'akaza1.jpeg' : 'akaza2.jpeg',
        collection: i % 3 === 0 ? 'Inspiration' : 'Uncategorized'
    }));

    posts.forEach(post => {
        const div = document.createElement('div');
        div.className = 'relative group';
        div.innerHTML = `
            <div class="aspect-square rounded-xl overflow-hidden">
                <img src="${post.image}" alt="Post" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity p-4">
                    <select class="w-full bg-[#1c1f3a] rounded-lg px-3 py-2 mt-auto block">
                        <option ${post.collection === 'Uncategorized' ? 'selected' : ''}>Uncategorized</option>
                        <option ${post.collection === 'Inspiration' ? 'selected' : ''}>Inspiration</option>
                        <option>Nature</option>
                        <option>Travel</option>
                    </select>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}

function updateStats() {
    // Simulate real-time stats updates
    setInterval(() => {
        const stats = document.querySelectorAll('.bg-[#161830] .font-medium');
        stats.forEach(stat => {
            if (stat.textContent.includes('K')) {
                const current = parseFloat(stat.textContent);
                stat.textContent = (current + Math.random() * 0.1).toFixed(1) + 'K';
            }
        });
    }, 5000);
}
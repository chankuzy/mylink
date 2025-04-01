document.addEventListener('DOMContentLoaded', () => {
    generateTrendingPosts();
    generateDiscoverPosts();
    generateTrendingCreators();
    initializeFilters();
    initializeInfiniteScroll();
});

function generateTrendingPosts() {
    const trendingGrid = document.querySelector('.grid-cols-2');
    for (let i = 1; i <= 2; i++) {
        const post = createTrendingPost(i);
        trendingGrid.appendChild(post);
    }
}

function createTrendingPost(index) {
    const div = document.createElement('div');
    div.className = 'relative aspect-[4/3] rounded-xl overflow-hidden group';
    div.innerHTML = `
        <img src="https://source.unsplash.com/random/800x600?trending&sig=${index}" 
             alt="Trending" 
             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5">
                    <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                        <img src="https://source.unsplash.com/random/100x100?portrait&sig=${index}" 
                             alt="Profile" 
                             class="w-full h-full rounded-full object-cover">
                    </div>
                </div>
                <span class="font-medium">trending_user_${index}</span>
            </div>
            <p class="text-sm text-gray-200">Amazing content #${index} 🌟 #trending #popular</p>
            <div class="flex items-center gap-4 mt-3">
                <button class="flex items-center gap-2 text-sm">
                    <i class="ri-heart-line"></i>
                    ${Math.floor(Math.random() * 50000 + 10000)}
                </button>
                <button class="flex items-center gap-2 text-sm">
                    <i class="ri-chat-1-line"></i>
                    ${Math.floor(Math.random() * 1000 + 100)}
                </button>
            </div>
        </div>
    `;
    return div;
}

function generateDiscoverPosts() {
    const postsGrid = document.querySelector('.posts-grid');
    for (let i = 1; i <= 9; i++) {
        const post = createDiscoverPost(i);
        postsGrid.appendChild(post);
    }
}

function createDiscoverPost(index) {
    const div = document.createElement('div');
    div.className = 'aspect-square rounded-xl overflow-hidden relative group cursor-pointer';
    div.setAttribute('data-category', getRandomCategory());
    div.innerHTML = `
        <img src="https://source.unsplash.com/random/800x800?sig=${index}" 
             alt="Discover" 
             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-6 text-lg">
            <span class="flex items-center gap-2">
                <i class="ri-heart-fill"></i> ${Math.floor(Math.random() * 5000)}
            </span>
            <span class="flex items-center gap-2">
                <i class="ri-chat-1-fill"></i> ${Math.floor(Math.random() * 200)}
            </span>
        </div>
    `;
    return div;
}

function generateTrendingCreators() {
    const creatorsContainer = document.querySelector('.bg-[#161830] h3 + div');
    const creators = [
        { name: 'artmaster', followers: '1.2M', category: 'Art' },
        { name: 'travelbug', followers: '850K', category: 'Travel' },
        { name: 'techgeek', followers: '620K', category: 'Technology' },
        { name: 'naturelens', followers: '945K', category: 'Photography' }
    ];

    creators.forEach(creator => {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between py-3';
        div.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5">
                    <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                        <img src="https://source.unsplash.com/random/100x100?portrait&${creator.name}" 
                             alt="${creator.name}" 
                             class="w-full h-full rounded-full object-cover">
                    </div>
                </div>
                <div>
                    <p class="font-medium">${creator.name}</p>
                    <p class="text-sm text-gray-400">${creator.category} • ${creator.followers} followers</p>
                </div>
            </div>
            <button class="text-blue-500 text-sm font-medium hover:text-blue-400 transition-colors">Follow</button>
        `;
        creatorsContainer.appendChild(div);
    });
}

function initializeFilters() {
    const filterButtons = document.querySelectorAll('button[class*="px-4"]');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-purple-500', 'to-blue-500');
                btn.classList.add('bg-[#161830]');
            });
            
            button.classList.remove('bg-[#161830]');
            button.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-blue-500');
            
            filterContent(button.textContent.trim());
        });
    });
}

function filterContent(category) {
    const posts = document.querySelectorAll('.posts-grid > div');
    posts.forEach(post => {
        if (category === 'All' || post.dataset.category === category) {
            post.style.display = 'block';
        } else {
            post.style.display = 'none';
        }
    });
}

function getRandomCategory() {
    const categories = ['Photography', 'Art', 'Technology', 'Travel'];
    return categories[Math.floor(Math.random() * categories.length)];
}

function initializeInfiniteScroll() {
    let isLoading = false;
    window.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        
        if (scrollTop + clientHeight >= scrollHeight - 800 && !isLoading) {
            isLoading = true;
            
            // Show loading indicator
            document.getElementById('loadingIndicator').classList.remove('hidden');
            
            // Simulate loading delay
            setTimeout(() => {
                const postsGrid = document.querySelector('.posts-grid');
                for (let i = 1; i <= 6; i++) {
                    const post = createDiscoverPost(Math.random());
                    postsGrid.appendChild(post);
                }
                
                isLoading = false;
                document.getElementById('loadingIndicator').classList.add('hidden');
            }, 1500);
        }
    });
}
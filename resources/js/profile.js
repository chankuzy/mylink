document.addEventListener('DOMContentLoaded', () => {
    generateHighlights();
    loadPosts();
    loadSimilarProfiles();
    initializeEditProfile();
    initializeTabSwitching();
    initializeImageUploads();
});

// Update the edit profile modal to use actual user data
function createEditProfileModal() {
    const div = document.createElement('div');
    div.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
    div.innerHTML = `
        <form class="bg-[#161830] rounded-xl p-6 w-[480px]" id="editProfileForm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold">Edit Profile</h3>
                <button type="button" class="hover:text-gray-400 transition-colors close-modal">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Name</label>
                    <input type="text" name="name" value="${currentUser.name}" 
                           class="w-full bg-[#0a0b1e] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Bio</label>
                    <textarea name="bio" class="w-full bg-[#0a0b1e] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none h-24">${currentUser.bio || ''}</textarea>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Website</label>
                    <input type="url" name="website" value="${currentUser.website || ''}" 
                           class="w-full bg-[#0a0b1e] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="w-full py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg font-medium">
                    Save Changes
                </button>
            </div>
        </form>
    `;

    // Handle form submission
    const form = div.querySelector('#editProfileForm');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch('/profile/update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.ok) {
                location.reload();
            }
        } catch (error) {
            console.error('Error updating profile:', error);
        }
    });

    return div;
}

// Update image upload handling
function triggerFileUpload(type) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = async (e) => {
        const file = e.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append(type === 'cover' ? 'cover_photo' : 'avatar', file);

            try {
                const response = await fetch(`/profile/${type === 'cover' ? 'cover-photo' : 'avatar'}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        }
    };
    input.click();
}

// Update posts loading
async function loadPosts() {
    const postsGrid = document.querySelector('.posts-grid');
    postsGrid.innerHTML = '';

    try {
        const response = await fetch(`/profile/${currentUser.username}/posts`);
        const posts = await response.json();

        posts.forEach(post => {
            const postElement = document.createElement('div');
            postElement.className = 'aspect-square rounded-xl overflow-hidden relative group cursor-pointer';
            postElement.innerHTML = `
                <img src="${post.image || post.thumbnail}" 
                     alt="Post" 
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-6">
                    <span class="flex items-center gap-2">
                        <i class="ri-heart-fill"></i> ${post.likes_count}
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="ri-chat-1-fill"></i> ${post.comments_count}
                    </span>
                </div>
            `;
            postsGrid.appendChild(postElement);
        });
    } catch (error) {
        console.error('Error loading posts:', error);
    }
}

function generateHighlights() {
    const highlightsContainer = document.querySelector('.hide-scrollbar');
    
    // Load user highlights from the server
    fetch(`/profile/highlights`)
        .then(response => response.json())
        .then(highlights => {
            highlights.forEach(highlight => {
                const highlightElement = createHighlightElement(highlight);
                highlightsContainer.appendChild(highlightElement);
            });
        })
        .catch(error => console.error('Error loading highlights:', error));
}

function createHighlightElement(highlight) {
    const div = document.createElement('div');
    div.className = 'flex flex-col items-center';
    div.innerHTML = `
        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5 cursor-pointer">
            <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                <img src="${highlight.cover_image}" 
                     alt="${highlight.title}" 
                     class="w-full h-full rounded-full object-cover">
            </div>
        </div>
        <span class="text-sm mt-2">${highlight.title}</span>
    `;

    div.addEventListener('click', () => openHighlightStories(highlight));
    return div;
}

function openHighlightStories(highlight) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="relative w-full max-w-md">
            <button class="absolute top-4 right-4 text-white/80 hover:text-white">
                <i class="ri-close-line text-2xl"></i>
            </button>
            <div class="stories-container"></div>
            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-1">
                ${highlight.stories.map((_, i) => `
                    <div class="w-16 h-1 bg-white/30 rounded-full story-progress" data-index="${i}"></div>
                `).join('')}
            </div>
        </div>
    `;

    let currentStoryIndex = 0;
    const storiesContainer = modal.querySelector('.stories-container');
    const progressBars = modal.querySelectorAll('.story-progress');

    function showStory(index) {
        storiesContainer.innerHTML = `
            <img src="${highlight.stories[index].image}" 
                 alt="Story ${index + 1}" 
                 class="max-h-[80vh] w-auto mx-auto">
        `;
        progressBars.forEach((bar, i) => {
            bar.classList.toggle('bg-white', i <= index);
        });
    }

    showStory(0);
    const storyDuration = 5000; // 5 seconds per story
    let storyInterval = setInterval(() => {
        currentStoryIndex++;
        if (currentStoryIndex >= highlight.stories.length) {
            modal.remove();
            clearInterval(storyInterval);
        } else {
            showStory(currentStoryIndex);
        }
    }, storyDuration);

    modal.querySelector('button').addEventListener('click', () => {
        modal.remove();
        clearInterval(storyInterval);
    });

    document.body.appendChild(modal);
}
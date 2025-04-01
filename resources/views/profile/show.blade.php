@props(['post'])
<x-layout>
<x-post-modal />
<main class="ml-72 flex-1 mr-96">
            <!-- Cover Photo -->
            <div class="h-60 rounded-xl overflow-hidden relative mb-16">
                <img src="{{ $user->cover_photo ?? Vite::asset('resources/images/akaza1.jpeg') }}" 
                     alt="Cover Photo" 
                     class="w-full h-full object-cover">
                
                <!-- Profile Picture -->
                <div class="absolute -bottom-12 left-8">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-1">
                        <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) ?? Vite::asset('resources/images/akaza2.jpeg') }}" 
                                     alt="{{ $user->username }}" 
                                     class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-600 flex items-center justify-center">
                                    <span class="text-2xl font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($user->id === auth()->id())
                    <button class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 rounded-full p-2 transition-all"
                            onclick="document.getElementById('coverPhotoInput').click()">
                        <i class="ri-camera-line text-xl"></i>
                    </button>
                    <input type="file" id="coverPhotoInput" class="hidden" accept="image/*">
                @endif
            </div>

            <!-- Profile Info -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    <p class="text-gray-400">{{ '@' . $user->username }}</p>
                    <p class="mt-4 max-w-lg">{{ $user->bio ?? 'No bio yet.' }}</p>
                </div>
                @if($user->id === auth()->id())
                    <a href="{{ route('profile.edit') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full font-medium">
                        Edit Profile
                    </a>
                @else
                    <button class="follow-button px-6 py-2 {{ auth()->user()->following->contains($user->id) 
                        ? 'bg-[#161830]' 
                        : 'bg-gradient-to-r from-purple-500 to-blue-500' }} rounded-full font-medium"
                            data-user-id="{{ $user->id }}">
                        {{ auth()->user()->following->contains($user->id) ? 'Following' : 'Follow' }}
                    </button>
                @endif
            </div>

            <!-- Stats -->
            <div class="flex gap-8 mb-8">
                <div class="text-center">
                    <span class="block font-bold text-xl">{{ $stats['posts_count'] }}</span>
                    <span class="text-gray-400">Posts</span>
                </div>
                <div class="text-center">
                    <span class="block font-bold text-xl">{{ $stats['followers_count'] }}</span>
                    <span class="text-gray-400">Followers</span>
                </div>
                <div class="text-center">
                    <span class="block font-bold text-xl">{{ $stats['following_count'] }}</span>
                    <span class="text-gray-400">Following</span>
                </div>
            </div>

            <!-- Posts Grid -->
            <div>
                <div class="flex gap-8 border-b border-gray-800 mb-8">
                    <button class="pb-4 border-b-2 border-blue-500 font-medium flex items-center gap-2">
                        <i class="ri-grid-line"></i> Posts
                    </button>
                    @if($user->id === auth()->id())
                        <button class="pb-4 text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                            <i class="ri-bookmark-line"></i> Saved
                        </button>
                        <button class="pb-4 text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                            <i class="ri-heart-line"></i> Liked
                        </button>
                    @endif
                </div>
                <div class="grid grid-cols-3 gap-4 posts-grid">
                    @foreach($posts as $post)
                        <div class="aspect-square bg-[#161830] rounded-xl overflow-hidden">
                            @if($post->media)
                                <div class="mt-3 rounded-xl overflow-hidden border border-gray-700">
                                    <img src="{{ asset('storage/' . $post->media) }}" 
                                        alt="Post by {{ $post->user->username }}" 
                                        class="w-full object-cover">
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center p-4">
                                    <p class="text-gray-300">{{ Str::limit($post->content, 100) }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        @push('scripts')
        <script>
            // Handle follow button
            const followBtn = document.querySelector('.follow-button');
            if (followBtn) {
                followBtn.addEventListener('click', async () => {
                    const userId = followBtn.dataset.userId;
                    try {
                        const response = await fetch(`/follow/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            const isFollowing = followBtn.textContent.trim() === 'Following';
                            followBtn.textContent = isFollowing ? 'Follow' : 'Following';
                            followBtn.classList.toggle('bg-[#161830]');
                            followBtn.classList.toggle('bg-gradient-to-r');
                            followBtn.classList.toggle('from-purple-500');
                            followBtn.classList.toggle('to-blue-500');
                            location.reload(); // Refresh to update counts
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Handle cover photo upload
            const coverPhotoInput = document.getElementById('coverPhotoInput');
            if (coverPhotoInput) {
                coverPhotoInput.addEventListener('change', async (e) => {
                    if (e.target.files.length > 0) {
                        const formData = new FormData();
                        formData.append('cover_photo', e.target.files[0]);

                        try {
                            const response = await fetch('/profile/cover-photo', {
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
                            console.error('Error uploading cover photo:', error);
                        }
                    }
                });
            }
        </script>
        @vite('resources/js/components/fab.js')
        @endpush
</x-layout>
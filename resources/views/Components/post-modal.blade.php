<div x-data="postModal">
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal Content -->
            <div class="relative bg-[#161830] w-[600px] rounded-2xl">
                <!-- Header -->
                <div class="flex items-center px-4 py-3 border-b border-gray-700">
                    <button @click="closeModal" class="p-2 hover:bg-[#1c1f3a] rounded-full">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                    <h2 class="ml-4 text-xl font-bold">Create post</h2>
                </div>

                <!-- User Info -->
                <div class="p-4 flex items-center gap-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-lg font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <span class="font-semibold">{{ auth()->user()->username }}</span>
                </div>

                <form id="postForm" class="px-4 pb-4" @submit.prevent="handleSubmit">                    @csrf
                    <input type="hidden" name="media" id="mediaInput">
                    <textarea 
                        name="content"
                        placeholder="What's happening?"
                        class="w-full bg-transparent text-xl resize-none focus:outline-none min-h-[150px]"
                    ></textarea>

                    <!-- Media Upload Area -->
                    <div id="mediaPost">
                        <div id="uploadArea" 
                             @click="document.getElementById('fileInput').click()"
                             @drop.prevent="handleFile($event)"
                             @dragover.prevent
                             @dragleave.prevent
                             class="border-2 border-dashed border-gray-700 rounded-xl p-4 text-center cursor-pointer hover:bg-[#1c1f3a]/50 transition-colors">
                            <i class="ri-image-add-line text-3xl mb-2"></i>
                            <p class="text-gray-400">Drag and drop or click to upload</p>
                            <!-- Preview Area -->
                            <div id="previewArea" class="hidden mt-4">
                                <div class="relative rounded-xl overflow-hidden">
                                    <img id="imagePreview" class="max-h-[300px] w-full object-cover">
                                    <!-- Add prevent default and stop propagation -->
                                    <button 
                                        @click.prevent.stop="discardImage" 
                                        class="absolute top-2 right-2 p-2 bg-black/50 hover:bg-black/75 rounded-full text-white transition-colors"
                                    >
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Update file input to accept only images -->
                            <input type="file" 
                                   id="fileInput" 
                                   class="hidden" 
                                   accept="image/*" 
                                   @change="handleFile($event)">
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-700">
                        <div class="flex gap-2">
                            <button type="button" class="p-2 hover:bg-[#1c1f3a] rounded-full" onclick="document.getElementById('fileInput').click()">
                                <i class="ri-image-line text-xl text-purple-500"></i>
                            </button>
                            <button type="button" class="p-2 hover:bg-[#1c1f3a] rounded-full">
                                <i class="ri-map-pin-line text-xl text-purple-500"></i>
                            </button>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full font-semibold">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('postModal', () => ({
            open: false,

            init() {
                window.openPostModal = () => this.open = true;
            },

            closeModal() {
                this.open = false;
                this.resetForm();
            },

            resetForm() {
                document.getElementById('postForm').reset();
                document.getElementById('mediaInput').value = '';
                document.getElementById('fileInput').value = '';
                document.getElementById('previewArea').classList.add('hidden');
                document.getElementById('imagePreview').src = '';
            },

            discardImage() {
                document.getElementById('mediaInput').value = '';
                document.getElementById('fileInput').value = '';
                document.getElementById('previewArea').classList.add('hidden');
                document.getElementById('imagePreview').src = '';
            },

            handleFile(event) {
                const file = event.type === 'drop' ? event.dataTransfer.files[0] : event.target.files[0];
                if (!file || !file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('mediaInput').value = e.target.result;
                    document.getElementById('previewArea').classList.remove('hidden');
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            handleSubmit(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                
                fetch('/posts', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const postsContainer = document.querySelector('.posts-feed');
                        if (postsContainer) {
                            postsContainer.insertAdjacentHTML('afterbegin', data.html);
                        }
                        this.resetForm();
                        this.open = false;
                        
                        if (window.showToast) {
                            window.showToast('Post created successfully!', 'success');
                        }
                    } else {
                        if (window.showToast) {
                            window.showToast(data.message || 'Error creating post', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (window.showToast) {
                        window.showToast('Error creating post. Please try again.', 'error');
                    }
                });
            }
        }));
    });
</script>
@endpush
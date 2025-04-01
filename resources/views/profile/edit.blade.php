<x-layout>
    <main class="ml-72 flex-1 mr-96">
        <div class="max-w-2xl mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="border-b border-white/10 w-full  outline-none focus:border-gray-400 focus:w-full transition-all duration-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Bio</label>
                    <textarea name="bio"
                    id="text-area"
                    rows="4"
                              class="border-b w-full border-white/10  outline-none focus:ring-4 ring-gray-400 rounded-xl p-4 focus:w-full transition-all duration-300 ">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Website</label>
                    <input type="url" name="website" value="{{ old('website', $user->website) }}" 
                           class="border-b w-full border-white/10  outline-none focus:border-gray-400 focus:w-full transition-all duration-300">
                    @error('website')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('profile.show', $user->username) }}" 
                       class="px-6 py-2 bg-[#161830] rounded-full">Cancel</a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-layout>
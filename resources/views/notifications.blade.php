<x-layout>
    <!-- Navigation Bar -->
        <!-- Main Notifications Content -->
        <main class="ml-72 flex-1 mr-96">
            <div class="bg-[#161830] rounded-xl">
                <!-- Notification Filters -->
                <div class="p-4 border-b border-gray-800">
                    <div class="flex gap-6">
                        <button class="pb-2 border-b-2 border-blue-500 font-medium">All</button>
                        <button class="pb-2 text-gray-400 hover:text-white transition-colors">Mentions</button>
                        <button class="pb-2 text-gray-400 hover:text-white transition-colors">Comments</button>
                        <button class="pb-2 text-gray-400 hover:text-white transition-colors">Likes</button>
                        <button class="pb-2 text-gray-400 hover:text-white transition-colors">Follows</button>
                    </div>
                </div>

                <!-- Today's Notifications -->
                <div class="p-4">
                    <h3 class="text-sm text-gray-400 mb-4">Today</h3>
                    <div class="space-y-4 notifications-today">
                        <!-- Notifications will be generated here -->
                    </div>
                </div>

                <!-- This Week -->
                <div class="p-4 border-t border-gray-800">
                    <h3 class="text-sm text-gray-400 mb-4">This Week</h3>
                    <div class="space-y-4 notifications-week">
                        <!-- Notifications will be generated here -->
                    </div>
                </div>

                <!-- Earlier -->
                <div class="p-4 border-t border-gray-800">
                    <h3 class="text-sm text-gray-400 mb-4">Earlier</h3>
                    <div class="space-y-4 notifications-earlier">
                        <!-- Notifications will be generated here -->
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="w-80 fixed right-4">
            <!-- Activity Stats -->
            <div class="bg-[#161830] rounded-xl p-4 mb-4">
                <h3 class="font-semibold mb-4">Activity Overview</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Profile visits</span>
                        <span class="font-medium">1,482</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">New followers</span>
                        <span class="font-medium">+248</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Post interactions</span>
                        <span class="font-medium">3.2K</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Graph -->
            <div class="bg-[#161830] rounded-xl p-4">
                <h3 class="font-semibold mb-4">Engagement Trend</h3>
                <div class="h-48" id="activityGraph">
                    <!-- Graph will be generated here -->
                </div>
            </div>
        </aside>
    </div>

    @push('scripts')
    @vite('resources/js/index.js')
    @vite('resources/js/notifications.js')
    @endpush
</x-layout>
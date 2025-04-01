<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Social Network')</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="bg-[#0a0b1e] text-white">
    <!-- Dynamic Navigation Bar -->
    <x-nav></x-nav>

    <!-- Main Content Area -->
    <div class="pt-20 container mx-auto px-4 flex gap-6">
        <!-- Left Sidebar -->
        <x-aside/>

        <!-- Main Feed -->
        {{ $slot }}
    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="hidden fixed bottom-4 right-4 bg-[#161830] p-2 rounded-lg">
        <div class="loading-spinner"></div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('create').addEventListener('click', () => {
                console.log('clicked');
                
                if (window.Alpine) {
                    const modal = document.querySelector('[x-data]');
                    if (modal && modal.__x) {
                        modal.__x.data.open = true;
                    }
                }
                if (typeof window.openPostModal === 'function') {
                    window.openPostModal();
                }
            })
        </script>
@endpush
</body>
</html>
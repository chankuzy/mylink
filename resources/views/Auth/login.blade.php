<x-simple-layout>
    <div class="w-full max-w-md p-8 overflow:hidden">
        <!-- Logo -->
        <h1 class="text-4xl font-bold text-center mb-8 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">Nexus</h1>
        
        <!-- Login Form -->
        <div class="bg-[#161830] rounded-xl p-6">
            <h2 class="text-2xl font-semibold mb-6">Welcome back</h2>
            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-2">Email or Username</label>
                    <input type="text" 
                           name="email"
                           placeholder="Enter your email"
                           value="{{ old('email') }}"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           data-validate="required">
                    <p class="text-red-500 text-sm mt-1" id="emailError"></p>
                </div>
                
                <div>
                    <label class="block text-sm mb-2">Password</label>
                    <input type="password" 
                           name="password"
                           placeholder="xxxxxxxx"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           data-validate="required">
                    <p class="text-red-500 text-sm mt-1" id="passwordError"></p>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 bg-[#0a0b1e] rounded">
                        <span class="text-sm">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-500 hover:text-blue-400">Forgot password?</a>
                </div>
                
                <button type="submit" 
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 rounded-lg font-medium hover:opacity-90 transition-opacity">
                    <span>Sign In</span>
                    <span class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>

                <!-- Social Login -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-[#161830] text-gray-400">Or continue with</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="button" 
                            class="flex items-center justify-center gap-2 bg-[#0a0b1e] py-2.5 rounded-lg hover:bg-[#0d0e24] transition-colors">
                        <i class="ri-google-fill text-xl"></i>
                        <span>Google</span>
                    </button>
                    <button type="button" 
                            class="flex items-center justify-center gap-2 bg-[#0a0b1e] py-2.5 rounded-lg hover:bg-[#0d0e24] transition-colors">
                        <i class="ri-github-fill text-xl"></i>
                        <span>GitHub</span>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('span:first-child');
        const btnLoading = submitBtn.querySelector('span:last-child');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btnLoading.classList.add('flex');
            submitBtn.disabled = true;

            try {
                const response = await fetch(loginForm.action, {
                    method: 'POST',
                    body: new FormData(loginForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();
                
                if (data.success) {
                    Toastify({
                        text: "Login success! Redirecting...",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #8B5CF6, #3B82F6)",
                        }
                    }).showToast();
    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    const errorElement = document.getElementById('emailError');
                    if (errorElement) {
                        errorElement.textContent = data.errors?.email?.[0] || 'Invalid credentials';
                    }
                    Toastify({
                        text: "Please check the form for errors",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "#EF4444",
                            borderRadius: "15px",
                        }
                    }).showToast();
                }
            } catch (error) {
                console.error('Login error:', error);
                const errorElement = document.getElementById('emailError');
                if (errorElement) {
                    errorElement.textContent = 'An error occurred. Please try again.';
                }
            } finally {
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                btnLoading.classList.remove('flex');
                submitBtn.disabled = false;
            }
        });
    </script>
    @endpush
</x-simple-layout>
<x-simple-layout>
    <div class="w-full max-w-md p-8">
        <!-- Logo -->
        <h1 class="text-4xl font-bold text-center mb-8 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">Nexus</h1>
        
        <!-- Register Form -->
        <div class="bg-[#161830] rounded-xl p-6">
            <h2 class="text-2xl font-semibold mb-6">Create an account</h2>
            
            <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-2">Full Name</label>
                    <input type="text"
                           name="name"
                           placeholder="Your name"
                           value="{{ old('name') }}"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <p class="text-red-500 text-sm mt-1" id="nameError"></p>
                </div>

                <div>
                    <label class="block text-sm mb-2">Username</label>
                    <input type="text" 
                           name="username"
                           placeholder="Your username"
                           value="{{ old('username') }}"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <p class="text-red-500 text-sm mt-1" id="usernameError"></p>
                </div>
                
                <div>
                    <label class="block text-sm mb-2">Email</label>
                    <input type="email" 
                           name="email"
                           placeholder="Your email"
                           value="{{ old('email') }}"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <p class="text-red-500 text-sm mt-1" id="emailError"></p>
                </div>
                
                <div>
                    <label class="block text-sm mb-2">Password</label>
                    <input type="password" 
                           name="password"
                           placeholder="xxxxxxxx"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <p class="text-red-500 text-sm mt-1" id="passwordError"></p>
                </div>

                <div>
                    <label class="block text-sm mb-2">Confirm Password</label>
                    <input type="password" 
                           name="password_confirmation"
                           placeholder="confirm it bro"
                           class="w-full bg-[#0a0b1e] text-sm font-bold rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <button type="submit" 
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 rounded-lg font-medium hover:opacity-90 transition-opacity flex items-center justify-center">
                    <span class="inline-block">Create Account</span>
                    <span class="hidden items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Processing...</span>
                    </span>
                </button>

                <!-- Social Register -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-[#161830] text-gray-400">Or sign up with</span>
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
                <p class="text-gray-400">Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('span:first-child');
        const btnLoading = submitBtn.querySelector('span:last-child');
        
        // Validation rules
        const validations = {
            name: {
                pattern: /^[a-zA-Z\s]{2,}$/,
                message: 'Name must be at least 2 characters long and contain only letters'
            },
            username: {
                pattern: /^[a-zA-Z0-9_]{3,}$/,
                message: 'Username must be at least 3 characters and contain only letters, numbers, and underscores'
            },
            email: {
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address'
            },
            password: {
                pattern: /.{8,}/,
                message: 'Password must be at least 8 characters long'
            }
        };
    
        // Real-time validation
        Object.keys(validations).forEach(field => {
            const input = registerForm.querySelector(`[name="${field}"]`);
            const errorElement = document.getElementById(`${field}Error`);
    
            input.addEventListener('input', () => {
                const isValid = validations[field].pattern.test(input.value);
                errorElement.textContent = isValid ? '' : validations[field].message;
                input.classList.toggle('ring-red-500', !isValid);
                input.classList.toggle('ring-2', !isValid);
            });
        });
    
        // Password confirmation validation
        const passwordConfirm = registerForm.querySelector('[name="password_confirmation"]');
        passwordConfirm.addEventListener('input', () => {
            const password = registerForm.querySelector('[name="password"]');
            const isValid = password.value === passwordConfirm.value;
            const errorElement = document.getElementById('passwordError');
            errorElement.textContent = isValid ? '' : 'Passwords do not match';
            passwordConfirm.classList.toggle('ring-red-500', !isValid);
            passwordConfirm.classList.toggle('ring-2', !isValid);
        });
    
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate all fields before submission
            let isValid = true;
            Object.keys(validations).forEach(field => {
                const input = registerForm.querySelector(`[name="${field}"]`);
                if (!validations[field].pattern.test(input.value)) {
                    isValid = false;
                    const errorElement = document.getElementById(`${field}Error`);
                    errorElement.textContent = validations[field].message;
                }
            });
    
            if (!isValid) return;
    
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btnLoading.classList.add('flex');
            submitBtn.disabled = true;
    
            try {
                const response = await fetch(registerForm.action, {
                    method: 'POST',
                    body: new FormData(registerForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
    
                const data = await response.json();
    
                if (data.success) {
                    Toastify({
                        text: "Registration successful! Redirecting...",
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
                    Object.entries(data.errors || {}).forEach(([field, messages]) => {
                        const errorElement = document.getElementById(`${field}Error`);
                        if (errorElement) {
                            errorElement.textContent = messages[0];
                        }
                    });
    
                    Toastify({
                        text: "Please check the form for errors",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "#EF4444",
                        }
                    }).showToast();
                }
            } catch (error) {
                Toastify({
                    text: "An error occurred. Please try again.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#EF4444",
                    }
                }).showToast();
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
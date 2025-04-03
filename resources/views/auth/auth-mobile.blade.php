<x-guest-layout>
    <div class="min-h-screen w-full bg-indigo-600 flex items-center justify-center">
        <div class="w-full max-w-[320px] px-4">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <!-- Header with Tabs -->
                <div class="flex border-b">
                    <a href="{{ url('/auth?view=mobile&mode=login') }}" 
                       class="flex-1 py-3 text-center {{ !request()->query('mode') || request()->query('mode') == 'login' ? 'text-indigo-600 font-medium' : 'text-gray-500' }}">
                        Masuk
                    </a>
                    <a href="{{ url('/auth?view=mobile&mode=register') }}" 
                       class="flex-1 py-3 text-center {{ request()->query('mode') == 'register' ? 'text-indigo-600 font-medium' : 'text-gray-500' }}">
                        Daftar
                    </a>
                </div>
                
                <!-- Content Area -->
                <div class="p-6">
                    <!-- Title -->
                    <div class="text-center mb-5">
                        <h1 class="text-xl font-bold text-gray-900">Event STEMBAYO</h1>
                        <p class="text-gray-500 text-xs">Platform Event Sekolah</p>
                    </div>

                    @if(!request()->query('mode') || request()->query('mode') == 'login')
                    <!-- Login Form -->
                    <form method="POST" action="{{ url('/auth/login') }}" class="space-y-4">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Email" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input 
                                    type="password"
                                    name="password" 
                                    placeholder="Password" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input 
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 text-xs text-gray-500">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md text-sm">
                            Masuk
                        </button>
                    </form>
                    
                    @else
                    
                    <!-- Register Form -->
                    <form method="POST" action="{{ url('/auth/register') }}" class="space-y-4">
                        @csrf
                        
                        <!-- Name Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input 
                                    type="text" 
                                    name="name" 
                                    placeholder="Nama Lengkap" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>
                        
                        <!-- Email Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Email" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input 
                                    type="password"
                                    name="password" 
                                    placeholder="Password" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input 
                                    type="password"
                                    name="password_confirmation" 
                                    placeholder="Konfirmasi Password" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Phone Number Input -->
                        <div class="relative">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <span class="pl-3 pr-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                <input 
                                    type="text" 
                                    name="nomer" 
                                    placeholder="Nomor HP" 
                                    class="w-full py-2 px-1 border-0 focus:ring-0 text-sm"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md text-sm">
                            Daftar
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="text-xs text-white">
                    SMK Negeri 2 Depok Sleman &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

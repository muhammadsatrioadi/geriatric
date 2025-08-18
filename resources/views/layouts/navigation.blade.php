<nav class="sticky top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/loho.png') }}" alt="Geriatric Care" class="rounded-circle h-auto w-12">
                </a>
                <!-- Khusus Admin -->
                <div class="hidden sm:flex sm:space-x-4 sm:ml-6">
                    @auth
                        <a href="{{ auth()->user()->role == 1 ? route('admin') : route('superadmin') }}"
                            class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

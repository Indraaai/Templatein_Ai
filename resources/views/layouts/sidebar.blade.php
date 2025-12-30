<!-- Sidebar -->
<div x-data="{ sidebarOpen: true, mobileMenuOpen: false }" class="flex h-screen bg-gray-50">

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="bg-white shadow-lg transition-all duration-300 flex flex-col fixed h-full z-50 lg:z-40
                  transform lg:transform-none"
        :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- Logo & Toggle -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center" x-show="sidebarOpen">
                <i class="fas fa-file-alt text-blue-600 text-2xl mr-2"></i>
                <span class="text-xl font-bold text-gray-800">Template<span class="text-blue-600">In AI</span></span>
            </a>
            <button @click="sidebarOpen = !sidebarOpen"
                class="hidden lg:block p-2 rounded-lg hover:bg-gray-100 transition">
                <i class="fas" :class="sidebarOpen ? 'fa-bars' : 'fa-bars'" class="text-gray-600"></i>
            </button>
            <button @click="mobileMenuOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                <i class="fas fa-times text-gray-600"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-home text-lg w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>

                @if (auth()->user()->role === 'admin')
                    <!-- Admin Navigation -->

                    <!-- Akademik Section -->
                    <div x-data="{ akademikOpen: {{ request()->routeIs('admin.faculties.*', 'admin.program-studies.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="akademikOpen = !akademikOpen"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.faculties.*', 'admin.program-studies.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap text-lg w-5"></i>
                                <span x-show="sidebarOpen" class="ml-3 font-medium">Akademik</span>
                            </div>
                            <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform"
                                :class="akademikOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="akademikOpen && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('admin.faculties.index') }}"
                                class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.faculties.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                                <i class="fas fa-building text-sm w-4"></i>
                                <span class="ml-2 text-sm">Fakultas</span>
                            </a>
                            <a href="{{ route('admin.program-studies.index') }}"
                                class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.program-studies.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                                <i class="fas fa-book text-sm w-4"></i>
                                <span class="ml-2 text-sm">Program Studi</span>
                            </a>
                        </div>
                    </div>

                    <!-- Template Management -->
                    <a href="{{ route('admin.templates.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.templates.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt text-lg w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Template</span>
                    </a>

                    <!-- Student Management -->
                    <a href="{{ route('admin.students.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.students.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-users text-lg w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Mahasiswa</span>
                    </a>

                    <!-- Document Review -->
                    <a href="{{ route('admin.documents.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.documents.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-check-circle text-lg w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Review Dokumen</span>
                    </a>
                @else
                    <!-- Student Navigation -->

                    <!-- Template Dokumen -->
                    <a href="{{ route('student.templates.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('student.templates.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-file-download text-lg w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Template</span>
                    </a>

                    <!-- Pemeriksaan AI -->
                    <a href="{{ route('student.documents.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('student.documents.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-robot text-lg w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Pemeriksaan AI</span>
                    </a>
                @endif
            </div>
        </nav>

        <!-- User Profile at Bottom -->
        <div class="border-t border-gray-200 p-3">
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen"
                    class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                    <div
                        class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div x-show="sidebarOpen" class="ml-3 text-left flex-1 min-w-0">
                        <div class="font-semibold text-gray-800 text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen" @click.away="profileOpen = false" x-transition
                    class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-2"></i>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 transition-all duration-300 w-full" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">

        <!-- Mobile Top Bar -->
        <div
            class="lg:hidden bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
            <button @click="mobileMenuOpen = true" class="p-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars text-gray-600 text-xl"></i>
            </button>
            <div class="flex items-center">
                <i class="fas fa-file-alt text-blue-600 text-xl mr-2"></i>
                <span class="text-lg font-bold text-gray-800">Template<span class="text-blue-600">In</span></span>
            </div>
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>

        <!-- Desktop Top Bar / Header -->
        <header class="hidden lg:block bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="px-6 py-4">
                {{ $header ?? '' }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>

<!-- Scripts Stack -->
@stack('scripts')

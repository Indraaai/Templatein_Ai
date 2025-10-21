<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-chart-line text-blue-600 mr-3"></i>Dashboard Admin
                </h2>
                <p class="text-gray-600 mt-1">Selamat datang kembali, {{ Auth::user()->name }}! 👋</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Templates</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_templates'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-file-alt mr-1"></i>Semua template
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-file-alt text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-3">
                        <a href="{{ route('admin.templates.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Active Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Template Aktif</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['active_templates'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>Siap digunakan
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-check-circle text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-6 py-3">
                        <a href="{{ route('admin.templates.index') }}"
                            class="text-sm text-green-600 hover:text-green-700 font-medium">
                            Kelola template <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Students -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Mahasiswa</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_students'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-users mr-1"></i>Pengguna aktif
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-3">
                        <a href="{{ route('admin.students.index') }}"
                            class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            Kelola mahasiswa <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Checks -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengecekan</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $stats['total_checks'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-robot mr-1"></i>Validasi AI
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-robot text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 px-6 py-3">
                        <a href="{{ route('admin.documents.index') }}"
                            class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                            Review dokumen <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <!-- Welcome Card -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 text-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-3">Selamat Datang di TemplateIn AI! 🎉</h3>
                                <p class="text-blue-100 mb-6 leading-relaxed">
                                    Kelola template dokumen akademik dengan mudah dan pantau aktivitas mahasiswa secara
                                    real-time menggunakan teknologi AI.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('admin.templates.create') }}"
                                        class="bg-white text-blue-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center shadow-md">
                                        <i class="fas fa-plus mr-2"></i>Buat Template Baru
                                    </a>
                                    <a href="{{ route('admin.students.index') }}"
                                        class="bg-blue-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-400 transition inline-flex items-center">
                                        <i class="fas fa-users mr-2"></i>Lihat Mahasiswa
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div
                                    class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line text-5xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>Statistik Cepat
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-building text-blue-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700">Fakultas</span>
                            </div>
                            <span class="text-lg font-bold text-blue-600">{{ \App\Models\Faculty::count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-indigo-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap text-indigo-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700">Program Studi</span>
                            </div>
                            <span
                                class="text-lg font-bold text-indigo-600">{{ \App\Models\ProgramStudy::count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-file-check text-green-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700">Dokumen Approved</span>
                            </div>
                            <span class="text-lg font-bold text-green-600">
                                {{ \App\Models\DocumentCheck::where('check_status', 'approved')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h4 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-rocket text-blue-600 mr-2"></i>Aksi Cepat
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.faculties.index') }}"
                        class="group p-5 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 border border-blue-200">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <h5 class="font-bold text-gray-800">Kelola Fakultas</h5>
                        </div>
                        <p class="text-sm text-gray-600">Tambah, edit, atau hapus fakultas</p>
                    </a>

                    <a href="{{ route('admin.program-studies.index') }}"
                        class="group p-5 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-200 border border-indigo-200">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <h5 class="font-bold text-gray-800">Program Studi</h5>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data program studi</p>
                    </a>

                    <a href="{{ route('admin.templates.index') }}"
                        class="group p-5 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 border border-green-200">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-alt text-white text-xl"></i>
                            </div>
                            <h5 class="font-bold text-gray-800">Kelola Template</h5>
                        </div>
                        <p class="text-sm text-gray-600">Buat dan edit template dokumen</p>
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                        class="group p-5 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 border border-purple-200">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <h5 class="font-bold text-gray-800">Data Mahasiswa</h5>
                        </div>
                        <p class="text-sm text-gray-600">Lihat dan kelola mahasiswa</p>
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 text-2xl mr-4"></i>
                        <div>
                            <h5 class="font-bold text-gray-800">System Information</h5>
                            <p class="text-sm text-gray-600">TemplateIn AI v1.0 - Template Management System</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            <i class="fas fa-circle text-xs mr-2 animate-pulse"></i>System Online
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

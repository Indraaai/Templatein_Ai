<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Templates -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Templates</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                            {{ $stats['total_templates'] }}
                        </div>
                    </div>
                </div>

                <!-- Active Templates -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Active Templates</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                            {{ $stats['active_templates'] }}
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Mahasiswa</div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                            {{ $stats['total_students'] }}
                        </div>
                    </div>
                </div>

                <!-- Total Checks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Pengecekan</div>
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">
                            {{ $stats['total_checks'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">👋 Selamat datang, Admin!</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Kelola template dokumen dan pantau aktivitas mahasiswa dari dashboard ini.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                        <a href="{{ route('admin.faculties.index') }}"
                            class="block p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                            <div class="font-semibold text-blue-600 dark:text-blue-400">🏫 Kelola Fakultas</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tambah, edit, atau hapus fakultas
                            </div>
                        </a>

                        <a href="{{ route('admin.program-studies.index') }}"
                            class="block p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition">
                            <div class="font-semibold text-indigo-600 dark:text-indigo-400">📚 Kelola Program Studi
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tambah, edit, atau hapus program
                                studi
                            </div>
                        </a>

                        <a href="#"
                            class="block p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                            <div class="font-semibold text-green-600 dark:text-green-400">� Kelola Template</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tambah, edit, atau hapus template
                                dokumen</div>
                        </a>

                        <a href="#"
                            class="block p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                            <div class="font-semibold text-purple-600 dark:text-purple-400">� Kelola Mahasiswa</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Lihat dan kelola data mahasiswa
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

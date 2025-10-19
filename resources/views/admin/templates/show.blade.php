<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Template') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.templates.edit', $template) }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 dark:bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 dark:hover:bg-yellow-600 focus:bg-yellow-700 dark:focus:bg-yellow-600 active:bg-yellow-900 dark:active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.templates.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div
                    class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Template Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Template</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama
                                        Template</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $template->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tipe
                                        Template</label>
                                    <p class="mt-1">
                                        <span
                                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                            @if ($template->type == 'skripsi') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                            @elseif($template->type == 'proposal') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($template->type == 'tugas_akhir') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300
                                            @elseif($template->type == 'laporan_praktikum') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($template->type == 'makalah') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $template->type)) }}
                                        </span>
                                    </p>
                                </div>

                                @if ($template->description)
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $template->description }}</p>
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fakultas</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">
                                            {{ $template->faculty->name ?? 'Semua Fakultas' }}</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Program
                                            Studi</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">
                                            {{ $template->programStudy->name ?? 'Semua Prodi' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                                        <p class="mt-1">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $template->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Total
                                            Download</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $template->download_count }}x
                                        </p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">
                                            {{ $template->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Structure -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Struktur Template</h3>

                            @if (isset($rules['sections']) && count($rules['sections']) > 0)
                                <div class="space-y-4">
                                    @foreach ($rules['sections'] as $index => $section)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                    {{ ucfirst($section['type']) }}
                                                    @if (isset($section['chapter_number']))
                                                        - BAB {{ $section['chapter_number'] }}
                                                    @endif
                                                </h4>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ count($section['elements'] ?? []) }} elemen
                                                </span>
                                            </div>

                                            @if (isset($section['elements']) && count($section['elements']) > 0)
                                                <div class="space-y-2">
                                                    @foreach ($section['elements'] as $element)
                                                        <div class="flex items-center text-sm">
                                                            <span
                                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300 mr-2">
                                                                {{ $element['type'] }}
                                                            </span>
                                                            @if (isset($element['text']))
                                                                <span class="text-gray-600 dark:text-gray-400 truncate">
                                                                    {{ Str::limit($element['text'], 60) }}
                                                                </span>
                                                            @elseif($element['type'] == 'list')
                                                                <span class="text-gray-600 dark:text-gray-400">
                                                                    {{ count($element['items'] ?? []) }} items
                                                                </span>
                                                            @elseif($element['type'] == 'table')
                                                                <span class="text-gray-600 dark:text-gray-400">
                                                                    {{ count($element['rows'] ?? []) }} rows
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada struktur tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Formatting Rules -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Format</h3>

                            @if (isset($rules['formatting']))
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran
                                            Halaman</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">
                                            {{ $rules['formatting']['page_size'] ?? 'A4' }}</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Orientasi</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">
                                            {{ ucfirst($rules['formatting']['orientation'] ?? 'portrait') }}</p>
                                    </div>

                                    @if (isset($rules['formatting']['margin']))
                                        <div class="col-span-2">
                                            <label
                                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">Margin
                                                (cm)</label>
                                            <p class="mt-1 text-gray-900 dark:text-white">
                                                Top: {{ $rules['formatting']['margin']['top'] ?? 3 }},
                                                Bottom: {{ $rules['formatting']['margin']['bottom'] ?? 3 }},
                                                Left: {{ $rules['formatting']['margin']['left'] ?? 4 }},
                                                Right: {{ $rules['formatting']['margin']['right'] ?? 3 }}
                                            </p>
                                        </div>
                                    @endif

                                    @if (isset($rules['formatting']['font']))
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">Font</label>
                                            <p class="mt-1 text-gray-900 dark:text-white">
                                                {{ $rules['formatting']['font']['name'] ?? 'Times New Roman' }}</p>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran
                                                Font</label>
                                            <p class="mt-1 text-gray-900 dark:text-white">
                                                {{ $rules['formatting']['font']['size'] ?? 12 }} pt</p>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">Jarak
                                                Baris</label>
                                            <p class="mt-1 text-gray-900 dark:text-white">
                                                {{ $rules['formatting']['font']['line_spacing'] ?? 1.5 }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada pengaturan format.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions & Stats -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>

                            <div class="space-y-3">
                                <a href="{{ route('admin.templates.download', $template) }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Template
                                </a>

                                <form action="{{ route('admin.templates.regenerate', $template) }}" method="POST"
                                    onsubmit="return confirm('Generate ulang dokumen template?');">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        Regenerate Dokumen
                                    </button>
                                </form>

                                <form action="{{ route('admin.templates.toggle-active', $template) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 {{ $template->is_active ? 'bg-gray-600 dark:bg-gray-500' : 'bg-green-600 dark:bg-green-500' }} border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        {{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.templates.destroy', $template) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus template ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 focus:bg-red-700 dark:focus:bg-red-600 active:bg-red-900 dark:active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus Template
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- File Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">File Template</h3>

                            @if ($template->template_file)
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama
                                            File</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white break-all">
                                            {{ basename($template->template_file) }}</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Path</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white break-all">
                                            {{ $template->template_file }}</p>
                                    </div>

                                    @php
                                        $fullPath = storage_path('app/' . $template->template_file);
                                        $fileExists = file_exists($fullPath);
                                        $fileSize = $fileExists ? filesize($fullPath) : 0;
                                    @endphp

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran
                                            File</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            @if ($fileExists)
                                                {{ number_format($fileSize / 1024, 2) }} KB
                                            @else
                                                <span class="text-red-600 dark:text-red-400">File tidak
                                                    ditemukan</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada file template.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Document Checks History -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Pemeriksaan
                            </h3>

                            @if ($template->documentChecks->count() > 0)
                                <div class="space-y-2">
                                    @foreach ($template->documentChecks->take(5) as $check)
                                        <div class="text-sm">
                                            <p class="text-gray-900 dark:text-white">{{ $check->user->name }}</p>
                                            <p class="text-gray-500 dark:text-gray-400">
                                                {{ $check->created_at->diffForHumans() }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($template->documentChecks->count() > 5)
                                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                        +{{ $template->documentChecks->count() - 5 }} lainnya
                                    </p>
                                @endif
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat pemeriksaan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

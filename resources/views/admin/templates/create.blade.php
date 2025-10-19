<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Template Baru') }}
            </h2>
            <a href="{{ route('admin.templates.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if ($errors->any())
                <div
                    class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative">
                    <strong class="font-bold">Oops! Ada yang salah.</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.templates.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar
                                </h3>

                                <!-- Template Name -->
                                <div class="mb-4">
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Template <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="e.g., Template Skripsi Teknik Informatika" required>
                                </div>

                                <!-- Template Type -->
                                <div class="mb-4">
                                    <label for="type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tipe Template <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="skripsi" {{ old('type') == 'skripsi' ? 'selected' : '' }}>Skripsi
                                        </option>
                                        <option value="proposal" {{ old('type') == 'proposal' ? 'selected' : '' }}>
                                            Proposal</option>
                                        <option value="tugas_akhir"
                                            {{ old('type') == 'tugas_akhir' ? 'selected' : '' }}>
                                            Tugas Akhir</option>
                                        <option value="laporan_praktikum"
                                            {{ old('type') == 'laporan_praktikum' ? 'selected' : '' }}>
                                            Laporan Praktikum</option>
                                        <option value="makalah" {{ old('type') == 'makalah' ? 'selected' : '' }}>
                                            Makalah</option>
                                        <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>

                                <!-- Faculty -->
                                <div class="mb-4">
                                    <label for="faculty_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="faculty_id" id="faculty_id"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach ($faculties as $faculty)
                                            <option value="{{ $faculty->id }}"
                                                {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Program Study -->
                                <div class="mb-4">
                                    <label for="program_study_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Program Studi
                                    </label>
                                    <div class="relative">
                                        <select name="program_study_id" id="program_study_id"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <option value="">-- Semua Program Studi (Template Umum) --</option>
                                        </select>
                                        <!-- Loading Spinner -->
                                        <div id="prodi-loading"
                                            class="hidden absolute right-10 top-1/2 transform -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-indigo-600 dark:text-indigo-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span><strong>Kosongkan</strong> jika template berlaku untuk <strong>semua
                                                    prodi</strong> dalam fakultas.</span>
                                        </span>
                                    </p>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Deskripsi
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Deskripsi singkat tentang template ini...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Rules Builder with Live Preview -->
                        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
                            <!-- Rules Builder - 60% -->
                            <div class="xl:col-span-3">
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            🎨 Visual Template Builder
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                            Buat struktur template Anda dengan mudah menggunakan visual builder. Tidak
                                            perlu
                                            coding!
                                        </p>

                                        @include('admin.templates.partials.rules-builder')
                                    </div>
                                </div>
                            </div>

                            <!-- Live Preview - 40% -->
                            <div class="xl:col-span-2">
                                @include('admin.templates.partials.live-preview')
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Status -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status</h3>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Aktifkan template
                                    </label>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Template yang aktif akan tersedia untuk diunduh mahasiswa
                                </p>
                            </div>
                        </div>

                        <!-- Help Card -->
                        <div class="bg-blue-50 dark:bg-blue-900 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">💡 Tips</h3>
                                <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-2 list-disc list-inside">
                                    <li>Gunakan "Load Sample" untuk memulai dengan template contoh</li>
                                    <li>Klik "Add Section" untuk menambah bagian baru (Cover/Chapter)</li>
                                    <li>Klik "Add Element" untuk menambah konten (Heading, Paragraph, dll)</li>
                                    <li>Klik "Edit" pada element untuk konfigurasi detail</li>
                                    <li>Drag section/element untuk mengubah urutan</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Element Types Reference -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📚 Jenis Element
                                </h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">📝</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Heading</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Judul/sub-judul (H1-H6)</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">📄</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Paragraph</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Paragraf teks biasa</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">•</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">List</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Daftar bullet/numbered</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">⊞</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Table</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Tabel data</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">🖼️</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Image</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Gambar/logo</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">---</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Page Break</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Halaman baru</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">↵</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Text Break</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Spasi vertikal</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-lg mr-2">━</span>
                                        <div>
                                            <strong class="text-gray-900 dark:text-white">Line</strong>
                                            <p class="text-gray-600 dark:text-gray-400">Garis horizontal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.templates.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Template
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Faculty-Prodi Dynamic Loading (AJAX)
            document.addEventListener('DOMContentLoaded', function() {
                const facultySelect = document.getElementById('faculty_id');
                const prodiSelect = document.getElementById('program_study_id');
                const prodiLoading = document.getElementById('prodi-loading');

                if (facultySelect && prodiSelect) {
                    facultySelect.addEventListener('change', function() {
                        const facultyId = this.value;

                        // Reset prodi
                        prodiSelect.innerHTML =
                            '<option value="">-- Semua Program Studi (Template Umum) --</option>';
                        prodiSelect.disabled = true;

                        if (facultyId) {
                            // Show loading
                            prodiLoading.classList.remove('hidden');

                            // Fetch program studies by faculty
                            fetch(`/admin/api/program-studies/${facultyId}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    // Hide loading
                                    prodiLoading.classList.add('hidden');
                                    prodiSelect.disabled = false;

                                    if (data.length > 0) {
                                        // Add program studies to dropdown
                                        data.forEach(prodi => {
                                            const option = document.createElement('option');
                                            option.value = prodi.id;
                                            option.textContent = prodi.name;
                                            prodiSelect.appendChild(option);
                                        });
                                    } else {
                                        // No program studies found
                                        prodiSelect.innerHTML =
                                            '<option value="">-- Tidak ada program studi --</option>';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error loading program studies:', error);
                                    prodiLoading.classList.add('hidden');
                                    prodiSelect.disabled = false;
                                    prodiSelect.innerHTML =
                                        '<option value="">-- Gagal memuat data --</option>';
                                });
                        } else {
                            prodiSelect.disabled = true;
                        }
                    });

                    // Trigger on load if faculty is already selected (for validation errors / old values)
                    @if (old('faculty_id'))
                        facultySelect.dispatchEvent(new Event('change'));
                        setTimeout(() => {
                            prodiSelect.value = '{{ old('program_study_id') }}';
                        }, 500);
                    @endif
                }
            });
        </script>
    @endpush
</x-app-layout>

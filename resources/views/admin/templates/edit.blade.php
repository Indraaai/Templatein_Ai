<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Template') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.templates.show', $template) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Detail
                </a>
                <a href="{{ route('admin.templates.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
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

            <form action="{{ route('admin.templates.update', $template) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

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
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $template->name) }}" required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                        placeholder="Contoh: Template Skripsi S1">
                                </div>

                                <!-- Template Type -->
                                <div class="mb-4">
                                    <label for="type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tipe Template <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type" required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <option value="">Pilih Tipe Template</option>
                                        <option value="skripsi"
                                            {{ old('type', $template->type) == 'skripsi' ? 'selected' : '' }}>Skripsi
                                        </option>
                                        <option value="proposal"
                                            {{ old('type', $template->type) == 'proposal' ? 'selected' : '' }}>Proposal
                                        </option>
                                        <option value="tugas_akhir"
                                            {{ old('type', $template->type) == 'tugas_akhir' ? 'selected' : '' }}>Tugas
                                            Akhir</option>
                                        <option value="laporan_praktikum"
                                            {{ old('type', $template->type) == 'laporan_praktikum' ? 'selected' : '' }}>
                                            Laporan Praktikum</option>
                                        <option value="makalah"
                                            {{ old('type', $template->type) == 'makalah' ? 'selected' : '' }}>Makalah
                                        </option>
                                        <option value="lainnya"
                                            {{ old('type', $template->type) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>

                                <!-- Faculty -->
                                <div class="mb-4">
                                    <label for="faculty_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="faculty_id" id="faculty_id" required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach ($faculties as $faculty)
                                            <option value="{{ $faculty->id }}"
                                                {{ old('faculty_id', $template->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kosongkan jika template
                                        untuk semua fakultas</p>
                                </div>

                                <!-- Program Study -->
                                <div class="mb-4">
                                    <label for="program_study_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Program Studi
                                    </label>
                                    <div class="relative">
                                        <select name="program_study_id" id="program_study_id"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <option value="">-- Semua Program Studi (Template Umum) --</option>
                                            @foreach ($programStudies as $prodi)
                                                <option value="{{ $prodi->id }}"
                                                    data-faculty="{{ $prodi->faculty_id }}"
                                                    {{ old('program_study_id', $template->program_study_id) == $prodi->id ? 'selected' : '' }}>
                                                    {{ $prodi->name }}
                                                </option>
                                            @endforeach
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
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                        placeholder="Deskripsi singkat tentang template ini...">{{ old('description', $template->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Template Rules -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Template Rules
                                        (JSON)</h3>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" onclick="formatJSON()"
                                            class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            Format JSON
                                        </button>
                                        <button type="button" onclick="loadSampleRules()"
                                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                            Load Sample
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="template_rules"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        JSON Rules <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="template_rules" id="template_rules" rows="20" required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 font-mono text-sm"
                                        placeholder='{"formatting": {...}, "sections": [...]}'>{{ old('template_rules', json_encode($currentRules, JSON_PRETTY_PRINT)) }}</textarea>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Format JSON untuk struktur
                                        template dokumen</p>
                                </div>

                                <!-- JSON Validation -->
                                <div id="json-validation" class="hidden">
                                    <div class="rounded-md p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg id="json-icon" class="h-5 w-5" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p id="json-message" class="text-sm font-medium"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Template Info -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Info Template</h3>

                                <div class="space-y-3 text-sm">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">ID:</span>
                                        <span class="text-gray-900 dark:text-white ml-2">{{ $template->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Dibuat:</span>
                                        <span
                                            class="text-gray-900 dark:text-white ml-2">{{ $template->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Diupdate:</span>
                                        <span
                                            class="text-gray-900 dark:text-white ml-2">{{ $template->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Total Download:</span>
                                        <span
                                            class="text-gray-900 dark:text-white ml-2">{{ $template->download_count }}x</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Reference -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📖 Panduan Singkat
                                </h3>

                                <div class="space-y-3 text-sm">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Element Types:</h4>
                                        <ul class="mt-1 text-gray-600 dark:text-gray-400 space-y-1">
                                            <li>• <code>heading</code> - Judul/heading</li>
                                            <li>• <code>paragraph</code> - Paragraf teks</li>
                                            <li>• <code>list</code> - Bullet/numbered list</li>
                                            <li>• <code>table</code> - Tabel</li>
                                            <li>• <code>image</code> - Gambar</li>
                                            <li>• <code>page_break</code> - Page break</li>
                                            <li>• <code>text_break</code> - Line break</li>
                                            <li>• <code>line</code> - Horizontal line</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="#"
                                        class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                        📚 Lihat Dokumentasi Lengkap
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Options -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status & Opsi</h3>

                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ old('is_active', $template->is_active) ? 'checked' : '' }}
                                            class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <label for="is_active"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                            Template aktif
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="regenerate" id="regenerate" value="1"
                                            {{ old('regenerate') ? 'checked' : '' }}
                                            class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <label for="regenerate"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                            Generate ulang dokumen
                                        </label>
                                    </div>
                                </div>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Dokumen akan di-generate ulang jika rules berubah atau checkbox dicentang
                                </p>
                            </div>
                        </div>

                        <!-- Submit Actions -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="space-y-3">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Update Template
                                    </button>

                                    <a href="{{ route('admin.templates.show', $template) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Sample rules data
            const sampleRules = @json(\App\Services\TemplateGeneratorService::getSampleRules());

            // Load sample rules
            function loadSampleRules() {
                if (confirm('Ini akan mengganti rules yang ada. Lanjutkan?')) {
                    document.getElementById('template_rules').value = JSON.stringify(sampleRules, null, 2);
                    validateJSON();
                }
            }

            // Format JSON
            function formatJSON() {
                const textarea = document.getElementById('template_rules');
                try {
                    const json = JSON.parse(textarea.value);
                    textarea.value = JSON.stringify(json, null, 2);
                    validateJSON();
                } catch (e) {
                    alert('JSON tidak valid, tidak bisa diformat: ' + e.message);
                }
            }

            // Faculty-Prodi Dynamic Loading (AJAX)
            const prodiLoading = document.getElementById('prodi-loading');

            facultySelect.addEventListener('change', function() {
                const facultyId = this.value;

                // Reset prodi
                prodiSelect.innerHTML = '<option value="">-- Semua Program Studi (Template Umum) --</option>';
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
                                    // Pre-select if this was the original value
                                    if (prodi.id == {{ $template->program_study_id ?? 'null' }}) {
                                        option.selected = true;
                                    }
                                    prodiSelect.appendChild(option);
                                });
                            } else {
                                // No program studies found
                                prodiSelect.innerHTML = '<option value="">-- Tidak ada program studi --</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading program studies:', error);
                            prodiLoading.classList.add('hidden');
                            prodiSelect.disabled = false;
                            prodiSelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
                        });
                } else {
                    prodiSelect.disabled = true;
                }
            });

            // Trigger on load to populate prodi based on selected faculty
            if (facultySelect.value) {
                facultySelect.dispatchEvent(new Event('change'));
            }

            // JSON validation
            document.getElementById('template_rules').addEventListener('input', validateJSON);

            function validateJSON() {
                const textarea = document.getElementById('template_rules');
                const validation = document.getElementById('json-validation');
                const icon = document.getElementById('json-icon');
                const message = document.getElementById('json-message');

                if (!textarea.value.trim()) {
                    validation.classList.add('hidden');
                    return;
                }

                try {
                    JSON.parse(textarea.value);
                    validation.classList.remove('hidden');
                    validation.className =
                        'bg-green-50 dark:bg-green-900/20 border border-green-400 dark:border-green-700 rounded-md p-4';
                    icon.className = 'h-5 w-5 text-green-400';
                    message.className = 'text-sm font-medium text-green-800 dark:text-green-300';
                    message.textContent = '✓ JSON valid';
                } catch (e) {
                    validation.classList.remove('hidden');
                    validation.className =
                        'bg-red-50 dark:bg-red-900/20 border border-red-400 dark:border-red-700 rounded-md p-4';
                    icon.className = 'h-5 w-5 text-red-400';
                    message.className = 'text-sm font-medium text-red-800 dark:text-red-300';
                    message.textContent = '✗ JSON error: ' + e.message;
                }
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Trigger faculty change to filter prodi on page load
                if (document.getElementById('faculty_id').value) {
                    document.getElementById('faculty_id').dispatchEvent(new Event('change'));
                }

                // Validate JSON on load
                validateJSON();
            });
        </script>
    @endpush
</x-app-layout>

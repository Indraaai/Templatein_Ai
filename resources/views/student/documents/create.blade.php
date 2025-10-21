<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload Dokumen untuk Pemeriksaan AI') }}
            </h2>
            <a href="{{ route('student.documents.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Petunjuk Penggunaan</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pilih template dokumen yang sesuai</li>
                                <li>Upload file PDF atau DOCX (max 10MB)</li>
                                <li>AI akan menganalisis dokumen Anda secara otomatis</li>
                                <li>Hasil analisis akan tersedia dalam beberapa menit</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('student.documents.store') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        @csrf

                        <!-- Template Selection -->
                        <div class="mb-6">
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Template Dokumen <span class="text-red-500">*</span>
                            </label>
                            <select name="template_id" id="template_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('template_id') border-red-300 @enderror">
                                <option value="">-- Pilih Template --</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}"
                                        {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->name }} ({{ $template->type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('template_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Pilih template yang sesuai dengan dokumen yang akan diupload
                            </p>
                        </div>

                        <!-- File Upload with Drag & Drop -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                File Dokumen <span class="text-red-500">*</span>
                            </label>

                            <div id="dropZone"
                                class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer @error('document') border-red-300 @enderror">
                                <input type="file" name="document" id="documentInput" class="hidden"
                                    accept=".pdf,.doc,.docx" required>

                                <div id="uploadPrompt">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-semibold text-blue-600 hover:text-blue-500">Klik untuk memilih
                                            file</span> atau drag & drop
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        PDF atau DOCX maksimal 10MB
                                    </p>
                                </div>

                                <div id="fileInfo" class="hidden">
                                    <div class="flex items-center justify-center">
                                        <svg class="h-8 w-8 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="text-left">
                                            <p id="fileName" class="text-sm font-medium text-gray-900"></p>
                                            <p id="fileSize" class="text-xs text-gray-500"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="removeFile"
                                        class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        Hapus file
                                    </button>
                                </div>
                            </div>

                            @error('document')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Progress Bar (hidden by default) -->
                            <div id="uploadProgress" class="hidden mt-4">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-blue-700">Mengupload...</span>
                                    <span class="text-sm font-medium text-blue-700" id="progressPercent">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div id="progressBar"
                                        class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Description (Optional) -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                placeholder="Tambahkan catatan jika diperlukan...">{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                Informasi tambahan tentang dokumen ini
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('student.documents.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Upload & Periksa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropZone = document.getElementById('dropZone');
                const documentInput = document.getElementById('documentInput');
                const uploadPrompt = document.getElementById('uploadPrompt');
                const fileInfo = document.getElementById('fileInfo');
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');
                const removeFileBtn = document.getElementById('removeFile');
                const uploadForm = document.getElementById('uploadForm');
                const submitBtn = document.getElementById('submitBtn');
                const uploadProgress = document.getElementById('uploadProgress');
                const progressBar = document.getElementById('progressBar');
                const progressPercent = document.getElementById('progressPercent');

                // Click to upload
                dropZone.addEventListener('click', () => documentInput.click());

                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // Highlight drop zone when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('border-blue-500', 'bg-blue-50');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                    });
                });

                // Handle dropped files
                dropZone.addEventListener('drop', (e) => {
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        documentInput.files = files;
                        handleFileSelect(files[0]);
                    }
                });

                // Handle file input change
                documentInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        handleFileSelect(this.files[0]);
                    }
                });

                // Remove file button
                removeFileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    documentInput.value = '';
                    uploadPrompt.classList.remove('hidden');
                    fileInfo.classList.add('hidden');
                });

                function handleFileSelect(file) {
                    // Validate file type
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Hanya file PDF atau DOCX yang diperbolehkan!');
                        documentInput.value = '';
                        return;
                    }

                    // Validate file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Ukuran file maksimal 10MB!');
                        documentInput.value = '';
                        return;
                    }

                    // Display file info
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    uploadPrompt.classList.add('hidden');
                    fileInfo.classList.remove('hidden');
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                }

                // Form submission with progress (simulated)
                uploadForm.addEventListener('submit', function(e) {
                    if (!documentInput.files.length) {
                        e.preventDefault();
                        alert('Silakan pilih file terlebih dahulu!');
                        return;
                    }

                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengupload...';

                    // Show progress bar
                    uploadProgress.classList.remove('hidden');

                    // Simulate progress (in real app, use XMLHttpRequest or fetch with progress events)
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += 10;
                        if (progress > 90) {
                            clearInterval(interval);
                        }
                        progressBar.style.width = progress + '%';
                        progressPercent.textContent = progress + '%';
                    }, 200);
                });
            });
        </script>
    @endpush
</x-app-layout>

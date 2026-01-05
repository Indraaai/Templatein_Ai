<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-cloud-upload-alt text-blue-600 mr-3"></i>Upload Dokumen
                </h2>
                <p class="text-gray-600 mt-1 text-sm">Upload dokumen untuk pemeriksaan AI otomatis</p>
            </div>
            <a href="{{ route('student.documents.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div
                class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-6 mb-8 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Petunjuk Penggunaan</h3>
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                                <p class="text-gray-700">Pilih template dokumen yang sesuai</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                                <p class="text-gray-700">Upload file PDF atau DOCX (max 10MB)</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                                <p class="text-gray-700">AI akan menganalisis dokumen Anda secara otomatis</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                                <p class="text-gray-700">Hasil analisis akan tersedia dalam beberapa menit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('student.documents.store') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        @csrf

                        <!-- Template Selection -->
                        <div class="mb-8">
                            <label for="template_id" class="block text-base font-semibold text-gray-900 mb-3">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>Template Dokumen <span
                                    class="text-red-500">*</span>
                            </label>
                            <select name="template_id" id="template_id" required
                                class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-base @error('template_id') border-red-300 @enderror">
                                <option value="">-- Pilih Template --</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}"
                                        {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->name }} ({{ $template->type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('template_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-600 flex items-center">
                                <i class="fas fa-lightbulb mr-1.5 text-gray-400"></i>
                                Pilih template yang sesuai dengan dokumen yang akan diupload
                            </p>
                        </div>

                        <!-- File Upload with Drag & Drop -->
                        <div class="mb-8">
                            <label class="block text-base font-semibold text-gray-900 mb-3">
                                <i class="fas fa-cloud-upload-alt text-blue-500 mr-2"></i>File Dokumen <span
                                    class="text-red-500">*</span>
                            </label>

                            <div id="dropZone"
                                class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center hover:border-blue-500 hover:bg-blue-50 transition-all cursor-pointer @error('document') border-red-300 @enderror">
                                <input type="file" name="document" id="documentInput" class="hidden"
                                    accept=".pdf,.doc,.docx" required>

                                <div id="uploadPrompt">
                                    <div
                                        class="w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-blue-500 text-3xl"></i>
                                    </div>
                                    <p class="text-base text-gray-700 mb-2">
                                        <span
                                            class="font-semibold text-blue-600 hover:text-blue-700 cursor-pointer">Klik
                                            untuk memilih file</span> atau drag & drop
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        PDF atau DOCX maksimal 10MB
                                    </p>
                                </div>

                                <div id="fileInfo" class="hidden">
                                    <div class="bg-white rounded-lg p-6 inline-block shadow-sm">
                                        <div class="flex items-center justify-center mb-3">
                                            <i class="fas fa-file-alt text-blue-500 text-4xl mr-4"></i>
                                            <div class="text-left">
                                                <p id="fileName" class="text-base font-semibold text-gray-900"></p>
                                                <p id="fileSize" class="text-sm text-gray-500"></p>
                                            </div>
                                        </div>
                                        <button type="button" id="removeFile"
                                            class="mt-2 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-colors">
                                            <i class="fas fa-times mr-2"></i>Hapus file
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @error('document')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror

                            <!-- Progress Bar (hidden by default) -->
                            <div id="uploadProgress" class="hidden mt-6">
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-blue-800 flex items-center">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...
                                        </span>
                                        <span class="text-sm font-bold text-blue-800" id="progressPercent">0%</span>
                                    </div>
                                    <div class="w-full bg-blue-200 rounded-full h-3 overflow-hidden">
                                        <div id="progressBar"
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300"
                                            style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description (Optional) -->
                        <div class="mb-8">
                            <label for="description" class="block text-base font-semibold text-gray-900 mb-3">
                                <i class="fas fa-comment-alt text-blue-500 mr-2"></i>Catatan (Opsional)
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                placeholder="Tambahkan catatan atau informasi tambahan tentang dokumen ini...">{{ old('description') }}</textarea>
                            <p class="mt-2 text-sm text-gray-600 flex items-center">
                                <i class="fas fa-lightbulb mr-1.5 text-gray-400"></i>
                                Informasi tambahan tentang dokumen ini
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('student.documents.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
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

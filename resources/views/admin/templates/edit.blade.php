<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <a href="{{ route('admin.templates.show', $template) }}"
                        class="text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-edit text-blue-600 mr-3"></i>Edit Template
                    </h2>
                </div>
                <p class="text-gray-600 ml-11">Edit informasi dan pengaturan template</p>
            </div>
            <a href="{{ route('admin.templates.builder', $template) }}"
                class="bg-purple-600 text-white px-5 py-2.5 rounded-lg hover:bg-purple-700 transition-all duration-200 flex items-center space-x-2 shadow-lg">
                <i class="fas fa-tools"></i>
                <span>Buka Builder</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-red-800 font-medium mb-2">Terdapat beberapa kesalahan:</p>
                            <ul class="list-disc list-inside text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.templates.update', $template) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Template Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Template <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $template->name) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Template Skripsi Teknik Informatika">
                            <p class="text-xs text-gray-500 mt-1.5">
                                <i class="fas fa-lightbulb mr-1"></i>Gunakan nama yang jelas dan deskriptif
                            </p>
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipe Dokumen <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih Tipe Dokumen</option>
                                <option value="skripsi"
                                    {{ old('type', $template->type) == 'skripsi' ? 'selected' : '' }}>Skripsi</option>
                                <option value="proposal"
                                    {{ old('type', $template->type) == 'proposal' ? 'selected' : '' }}>Proposal</option>
                                <option value="tugas_akhir"
                                    {{ old('type', $template->type) == 'tugas_akhir' ? 'selected' : '' }}>Tugas Akhir
                                </option>
                                <option value="laporan_praktikum"
                                    {{ old('type', $template->type) == 'laporan_praktikum' ? 'selected' : '' }}>Laporan
                                    Praktikum</option>
                                <option value="makalah"
                                    {{ old('type', $template->type) == 'makalah' ? 'selected' : '' }}>Makalah</option>
                                <option value="lainnya"
                                    {{ old('type', $template->type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Jelaskan detail template ini...">{{ old('description', $template->description) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1.5">
                                <i class="fas fa-info-circle mr-1"></i>Opsional: Tambahkan deskripsi untuk memudahkan
                                identifikasi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-graduation-cap mr-2"></i>Informasi Akademik
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Faculty -->
                        <div>
                            <label for="faculty_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Fakultas <span class="text-red-500">*</span>
                            </label>
                            <select name="faculty_id" id="faculty_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih Fakultas</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}"
                                        {{ old('faculty_id', $template->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Program Study -->
                        <div>
                            <label for="program_study_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Program Studi
                            </label>
                            <select name="program_study_id" id="program_study_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih Program Studi (Opsional)</option>
                                @foreach ($programStudies as $programStudy)
                                    <option value="{{ $programStudy->id }}"
                                        data-faculty="{{ $programStudy->faculty_id }}"
                                        {{ old('program_study_id', $template->program_study_id) == $programStudy->id ? 'selected' : '' }}>
                                        {{ $programStudy->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1.5">
                                <i class="fas fa-info-circle mr-1"></i>Kosongkan jika template berlaku untuk semua
                                program studi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Template Rules (Preview Only) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-cog mr-2"></i>Aturan Template
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-blue-900 font-medium mb-1">Gunakan Template Builder</p>
                                    <p class="text-blue-800 text-sm">
                                        Untuk mengubah aturan template seperti format dokumen, margins, font, dan
                                        struktur dokumen,
                                        silakan gunakan <strong>Template Builder</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>

                        @php
                            $rules = json_decode($template->template_rules, true);
                        @endphp

                        @if (isset($rules['formatting']))
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-font text-blue-600 mr-2"></i>Format Saat Ini
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-500">Font</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $rules['formatting']['font']['name'] ?? 'Times New Roman' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Ukuran</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $rules['formatting']['font']['size'] ?? 12 }}pt</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Spasi</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $rules['formatting']['font']['line_spacing'] ?? 1.5 }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Kertas</p>
                                        <p class="font-medium text-gray-900">
                                            {{ strtoupper($rules['formatting']['page_size'] ?? 'A4') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('admin.templates.builder', $template) }}"
                                class="inline-flex items-center space-x-2 px-5 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                <i class="fas fa-tools"></i>
                                <span>Buka Template Builder</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>

                        <!-- Hidden field untuk template_rules -->
                        <input type="hidden" name="template_rules" value="{{ $template->template_rules }}">
                    </div>
                </div>

                <!-- Status & Options -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-toggle-on mr-2"></i>Status & Opsi
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Active Status -->
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $template->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 mt-0.5">
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Aktifkan Template</span>
                                <p class="text-xs text-gray-500">Template aktif dapat digunakan oleh mahasiswa</p>
                            </div>
                        </label>

                        <!-- Regenerate Option -->
                        <div class="pt-4 border-t border-gray-100">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="regenerate" value="1"
                                    class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500 mt-0.5">
                                <div>
                                    <span class="text-sm font-semibold text-gray-700">Regenerate Dokumen
                                        Template</span>
                                    <p class="text-xs text-gray-500">Buat ulang file .docx template dengan aturan
                                        terbaru</p>
                                </div>
                            </label>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-yellow-800">
                                        <strong>Penting:</strong> Jika Anda mengubah informasi fakultas atau program
                                        studi,
                                        pastikan untuk regenerate dokumen template agar perubahan diterapkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="flex items-center justify-between space-x-4 sticky bottom-6 bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                    <a href="{{ route('admin.templates.show', $template) }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="confirmSave()"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Save Confirmation Modal -->
    <div id="saveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4"
        style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-save text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Simpan Perubahan?</h3>
                <p class="text-gray-600 text-center mb-6">Pastikan semua data sudah benar sebelum menyimpan.</p>
                <div class="flex space-x-3">
                    <button onclick="closeSaveModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
                        Periksa Lagi
                    </button>
                    <button onclick="submitForm()"
                        class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium">
                        <i class="fas fa-check mr-2"></i>Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Faculty change handler
            document.getElementById('faculty_id').addEventListener('change', function() {
                const facultyId = this.value;
                const programStudySelect = document.getElementById('program_study_id');

                // Show all options first
                const options = programStudySelect.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value === '') {
                        option.style.display = 'block';
                        return;
                    }

                    const optionFaculty = option.getAttribute('data-faculty');
                    if (facultyId && optionFaculty !== facultyId) {
                        option.style.display = 'none';
                        if (option.selected) {
                            programStudySelect.value = '';
                        }
                    } else {
                        option.style.display = 'block';
                    }
                });

                // If no faculty selected, load from API
                if (!facultyId) {
                    programStudySelect.value = '';
                    return;
                }

                // Load fresh data from API
                fetch(`/api/program-studies/${facultyId}`)
                    .then(response => response.json())
                    .then(data => {
                        const currentValue = programStudySelect.value;
                        programStudySelect.innerHTML = '<option value="">Pilih Program Studi (Opsional)</option>';

                        data.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.id;
                            option.textContent = program.name;
                            option.setAttribute('data-faculty', facultyId);
                            if (currentValue == program.id) {
                                option.selected = true;
                            }
                            programStudySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Trigger on page load if faculty is selected
            if (document.getElementById('faculty_id').value) {
                document.getElementById('faculty_id').dispatchEvent(new Event('change'));
            }

            function confirmSave() {
                document.getElementById('saveModal').style.display = 'flex';
            }

            function closeSaveModal() {
                document.getElementById('saveModal').style.display = 'none';
            }

            function submitForm() {
                document.querySelector('form').submit();
            }

            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSaveModal();
                }
            });

            // Close modal on outside click
            document.getElementById('saveModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSaveModal();
                }
            });
        </script>
    @endpush
</x-app-layout>

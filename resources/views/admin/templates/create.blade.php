<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <a href="{{ route('admin.templates.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-plus-circle text-blue-600 mr-3"></i>Buat Template Baru
                    </h2>
                </div>
                <p class="text-gray-600 ml-11">Buat template dokumen akademik baru</p>
            </div>
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

            <form action="{{ route('admin.templates.store') }}" method="POST" class="space-y-6">
                @csrf

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
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                <option value="skripsi" {{ old('type') == 'skripsi' ? 'selected' : '' }}>Skripsi
                                </option>
                                <option value="proposal" {{ old('type') == 'proposal' ? 'selected' : '' }}>Proposal
                                </option>
                                <option value="tugas_akhir" {{ old('type') == 'tugas_akhir' ? 'selected' : '' }}>Tugas
                                    Akhir</option>
                                <option value="laporan_praktikum"
                                    {{ old('type') == 'laporan_praktikum' ? 'selected' : '' }}>Laporan Praktikum
                                </option>
                                <option value="makalah" {{ old('type') == 'makalah' ? 'selected' : '' }}>Makalah
                                </option>
                                <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Jelaskan detail template ini...">{{ old('description') }}</textarea>
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
                                        {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
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
                            </select>
                            <p class="text-xs text-gray-500 mt-1.5">
                                <i class="fas fa-info-circle mr-1"></i>Kosongkan jika template berlaku untuk semua
                                program studi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-toggle-on mr-2"></i>Status Template
                        </h3>
                    </div>
                    <div class="p-6">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active') ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Aktifkan Template</span>
                                <p class="text-xs text-gray-500">Template aktif dapat digunakan oleh mahasiswa</p>
                            </div>
                        </label>
                        <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Catatan:</strong> Anda bisa mengaktifkan template nanti setelah mengatur
                                struktur template di builder.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between space-x-4">
                    <a href="{{ route('admin.templates.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Simpan & Lanjut ke Builder
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('faculty_id').addEventListener('change', function() {
                const facultyId = this.value;
                const programStudySelect = document.getElementById('program_study_id');

                // Reset program study select
                programStudySelect.innerHTML = '<option value="">Loading...</option>';

                if (facultyId) {
                    fetch(`/api/program-studies/${facultyId}`)
                        .then(response => response.json())
                        .then(data => {
                            programStudySelect.innerHTML =
                                '<option value="">Pilih Program Studi (Opsional)</option>';
                            data.forEach(program => {
                                const option = document.createElement('option');
                                option.value = program.id;
                                option.textContent = program.name;
                                programStudySelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            programStudySelect.innerHTML = '<option value="">Error loading data</option>';
                        });
                } else {
                    programStudySelect.innerHTML = '<option value="">Pilih Program Studi (Opsional)</option>';
                }
            });

            // Trigger on page load if faculty is selected
            if (document.getElementById('faculty_id').value) {
                document.getElementById('faculty_id').dispatchEvent(new Event('change'));
            }
        </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Mahasiswa') }}
            </h2>
            <a href="{{ route('admin.students.index') }}"
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.students.update', $student) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $student->name) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., John Doe" required autofocus>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $student->email) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., john.doe@example.com" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Email akan digunakan sebagai username untuk login
                            </p>
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-600">

                        <!-- Password Section -->
                        <div
                            class="mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-300">
                                        Update Password
                                    </h4>
                                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                        Kosongkan kolom password jika tidak ingin mengubah password mahasiswa.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password Baru
                            </label>
                            <input type="password" name="password" id="password"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Minimal 8 karakter (kosongkan jika tidak diubah)">
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ulangi password baru">
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-600">

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
                                        {{ old('faculty_id', $student->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Program Study -->
                        <div class="mb-4">
                            <label for="program_study_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Program Studi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="program_study_id" id="program_study_id"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                    required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($programStudies as $prodi)
                                        <option value="{{ $prodi->id }}"
                                            {{ old('program_study_id', $student->program_study_id) == $prodi->id ? 'selected' : '' }}>
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
                                Pilih fakultas terlebih dahulu untuk memuat program studi
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.students.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Mahasiswa
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
                const facultySelect = document.getElementById('faculty_id');
                const prodiSelect = document.getElementById('program_study_id');
                const prodiLoading = document.getElementById('prodi-loading');
                const originalProdiId = {{ $student->program_study_id ?? 'null' }};

                if (!facultySelect || !prodiSelect) return;

                // Function to load program studies
                function loadProgramStudies(facultyId, selectedProdiId = null) {
                    // Save current value before resetting
                    const currentValue = selectedProdiId || prodiSelect.value;
                    console.log('loadProgramStudies called with facultyId:', facultyId, 'selectedProdiId:',
                        selectedProdiId, 'currentValue:', currentValue);

                    // Reset prodi
                    prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
                    prodiSelect.disabled = true;

                    if (!facultyId) {
                        console.log('No faculty ID provided, returning');
                        return;
                    }

                    // Show loading
                    prodiLoading.classList.remove('hidden');

                    const apiUrl = `/api/program-studies/${facultyId}`;
                    console.log('Fetching from:', apiUrl);

                    // Fetch program studies by faculty
                    fetch(apiUrl)
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Received data:', data);
                            console.log('Data type:', typeof data);
                            console.log('Is array:', Array.isArray(data));
                            console.log('Data length:', data ? data.length : 'null');

                            // Hide loading
                            prodiLoading.classList.add('hidden');
                            prodiSelect.disabled = false;

                            if (data && Array.isArray(data) && data.length > 0) {
                                console.log(`Adding ${data.length} program studies to dropdown`);

                                // Clear and add default option
                                prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';

                                // Add program studies to dropdown
                                data.forEach((prodi, index) => {
                                    console.log(`Adding option ${index + 1}:`, prodi);
                                    const option = document.createElement('option');
                                    option.value = prodi.id;
                                    option.textContent = prodi.name;

                                    // Pre-select if this was the original/current value
                                    if (prodi.id == currentValue) {
                                        option.selected = true;
                                        console.log('Pre-selected prodi:', prodi.name);
                                    }

                                    prodiSelect.appendChild(option);
                                });

                                console.log('Total options in select:', prodiSelect.options.length);
                            } else {
                                console.log('No program studies found for this faculty');
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
                            alert('Gagal memuat data program studi. Silakan coba lagi atau hubungi administrator.');
                        });
                }

                // Event listener for faculty change
                facultySelect.addEventListener('change', function() {
                    const facultyId = this.value;
                    console.log('Faculty changed to:', facultyId);
                    loadProgramStudies(facultyId);
                });

                // Load program studies on page load to refresh via AJAX
                // This ensures consistency with create page behavior
                if (facultySelect.value) {
                    console.log('Loading program studies for faculty:', facultySelect.value, 'Original prodi:',
                        originalProdiId);
                    loadProgramStudies(facultySelect.value, originalProdiId);
                }

                // Form validation before submit
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Enable prodi select before submit to ensure value is sent
                        if (prodiSelect.disabled) {
                            e.preventDefault();
                            alert('Silakan pilih Program Studi terlebih dahulu.');
                            return false;
                        }

                        // Check if prodi has value
                        if (!prodiSelect.value) {
                            e.preventDefault();
                            alert('Silakan pilih Program Studi terlebih dahulu.');
                            prodiSelect.focus();
                            return false;
                        }

                        console.log('Form submitted with program_study_id:', prodiSelect.value);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>

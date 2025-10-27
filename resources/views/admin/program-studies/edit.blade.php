<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Program Studi') }}
            </h2>
            <a href="{{ route('admin.program-studies.index') }}"
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
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="p-6 sm:p-8">
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            Edit Informasi Program Studi
                        </h3>
                        <p class="text-sm text-gray-500">
                            Perbarui informasi program studi di bawah ini.
                        </p>
                    </div>

                    <form action="{{ route('admin.program-studies.update', $programStudy) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Faculty -->
                        <div>
                            <x-input-label for="faculty_id" :value="__('Fakultas')" />
                            <select id="faculty_id" name="faculty_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Pilih Fakultas</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}"
                                        {{ old('faculty_id', $programStudy->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pilih fakultas untuk program studi ini.
                            </p>
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Program Studi')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $programStudy->name)" required autofocus placeholder="Contoh: Teknik Informatika" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Masukkan nama program studi lengkap dan jelas.
                            </p>
                        </div>

                        <!-- Info about related data -->
                        <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Perhatian
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Program studi ini memiliki <strong>{{ $programStudy->users->count() }}
                                                mahasiswa</strong>. Perubahan akan mempengaruhi semua data terkait.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-100"></div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ route('admin.program-studies.index') }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                            <x-primary-button class="w-full sm:w-auto justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Update Program Studi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Informasi Tambahan
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Dibuat pada: {{ $programStudy->created_at->format('d M Y, H:i') }}</li>
                                <li>Terakhir diupdate: {{ $programStudy->updated_at->format('d M Y, H:i') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

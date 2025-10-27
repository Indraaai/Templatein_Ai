<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Mahasiswa') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.students.edit', $student) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.students.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="p-6">
                            <!-- Avatar -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                </div>
                                <h3 class="mt-4 text-xl font-semibold text-gray-900 text-center">
                                    {{ $student->name }}
                                </h3>
                                <p class="text-sm text-gray-500 text-center">
                                    {{ $student->email }}
                                </p>

                                <!-- Status Badge -->
                                <div class="mt-4">
                                    @if ($student->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Akun Terverifikasi
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Belum Verifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Info Details -->
                            <div class="mt-6 space-y-4">
                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div class="flex-1">
                                            <div class="text-gray-500">Terdaftar</div>
                                            <div class="font-medium text-gray-900">
                                                {{ $student->created_at->format('d F Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <div class="text-gray-500">Terakhir Update</div>
                                            <div class="font-medium text-gray-900">
                                                {{ $student->updated_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini? Semua data terkait akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus Mahasiswa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Academic Information -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                📚 Informasi Akademik
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Faculty -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Fakultas
                                    </label>
                                    <div class="flex items-center">
                                        <span
                                            class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-blue-50 text-blue-700">
                                            🏫 {{ $student->faculty->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Program Study -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Program Studi
                                    </label>
                                    <div class="flex items-center">
                                        <span
                                            class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700">
                                            📖 {{ $student->programStudy->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Total Checks -->
                        <div
                            class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-sm rounded-xl border border-blue-100">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-blue-100">
                                            Total Pengecekan
                                        </div>
                                        <div class="text-3xl font-bold text-white mt-2">
                                            {{ $student->documentChecks->count() }}
                                        </div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-3">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passed -->
                        <div
                            class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-sm rounded-xl border border-green-100">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-green-100">
                                            Lulus
                                        </div>
                                        <div class="text-3xl font-bold text-white mt-2">
                                            {{ $student->documentChecks->where('status', 'passed')->count() }}
                                        </div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-3">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Failed -->
                        <div
                            class="bg-gradient-to-br from-red-500 to-red-600 overflow-hidden shadow-sm rounded-xl border border-red-100">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-red-100">
                                            Tidak Lulus
                                        </div>
                                        <div class="text-3xl font-bold text-white mt-2">
                                            {{ $student->documentChecks->where('status', 'failed')->count() }}
                                        </div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-3">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Checks History -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="p-6 sm:p-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    📋 Riwayat Pengecekan Dokumen
                                </h3>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $student->documentChecks->count() }} Total
                                </span>
                            </div>

                            @if ($student->documentChecks->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($student->documentChecks->take(5) as $check)
                                        <div
                                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $check->template->name ?? 'Template tidak tersedia' }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $check->created_at->format('d M Y, H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                @if ($check->status === 'passed')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                        ✓ Lulus
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                                        ✗ Tidak Lulus
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($student->documentChecks->count() > 5)
                                        <div class="text-center pt-2">
                                            <span class="text-sm text-gray-500">
                                                Dan {{ $student->documentChecks->count() - 5 }} pengecekan lainnya...
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="mt-4 text-sm font-medium text-gray-900">
                                        Belum ada pengecekan dokumen
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Mahasiswa ini belum pernah melakukan pengecekan dokumen.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>

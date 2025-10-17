<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Fakultas') }}
            </h2>
            <a href="{{ route('admin.faculties.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Faculty Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $faculty->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Dibuat: {{ $faculty->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.faculties.edit', $faculty) }}"
                                class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.faculties.destroy', $faculty) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus fakultas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Program Studi</div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                            {{ $faculty->programStudies->count() }}
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Mahasiswa</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                            {{ $faculty->users->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Studies List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Daftar Program Studi
                    </h4>

                    @if ($faculty->programStudies->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($faculty->programStudies as $prodi)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $prodi->name }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $prodi->users->count() }} mahasiswa
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 dark:text-gray-600 text-4xl mb-2">📚</div>
                            <p class="text-gray-600 dark:text-gray-400">Belum ada program studi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

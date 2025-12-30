<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-blue-600 mr-3"></i>Manajemen Template
                </h2>
                <p class="text-gray-600 mt-1">Kelola template dokumen akademik untuk mahasiswa</p>
            </div>
            <a href="{{ route('admin.templates.create') }}"
                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Buat Template Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Template</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Template Aktif</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inactive Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Template Nonaktif</p>
                                <p class="text-3xl font-bold text-gray-600">{{ $stats['inactive'] }}</p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-pause-circle text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Downloads -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Unduhan</p>
                                <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['downloads']) }}
                                </p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-download text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.templates.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-search mr-1"></i>Cari Template
                                </label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau deskripsi..."
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <!-- Faculty Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-building mr-1"></i>Fakultas
                                </label>
                                <select name="faculty_id" id="facultyFilter"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Semua Fakultas</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-1"></i>Tipe Dokumen
                                </label>
                                <select name="type"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Semua Tipe</option>
                                    <option value="skripsi" {{ request('type') == 'skripsi' ? 'selected' : '' }}>
                                        Skripsi</option>
                                    <option value="proposal" {{ request('type') == 'proposal' ? 'selected' : '' }}>
                                        Proposal</option>
                                    <option value="tugas_akhir"
                                        {{ request('type') == 'tugas_akhir' ? 'selected' : '' }}>Tugas Akhir</option>
                                    <option value="laporan_praktikum"
                                        {{ request('type') == 'laporan_praktikum' ? 'selected' : '' }}>Laporan
                                        Praktikum</option>
                                    <option value="makalah" {{ request('type') == 'makalah' ? 'selected' : '' }}>
                                        Makalah</option>
                                    <option value="lainnya" {{ request('type') == 'lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-toggle-on mr-1"></i>Status
                                </label>
                                <select name="is_active"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
                                        Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-filter"></i>
                                <span>Terapkan Filter</span>
                            </button>
                            <a href="{{ route('admin.templates.index') }}"
                                class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-200 transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-redo"></i>
                                <span>Reset</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Templates Grid -->
            @if ($templates->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($templates as $template)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden group">
                            <!-- Header -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3
                                            class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition">
                                            {{ $template->name }}
                                        </h3>
                                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i class="fas fa-building mr-1.5 text-gray-400"></i>
                                                {{ $template->faculty->name }}
                                            </span>
                                        </div>
                                        @if ($template->programStudy)
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i
                                                    class="fas fa-graduation-cap mr-1"></i>{{ $template->programStudy->name }}
                                            </p>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($template->is_active)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                <i class="fas fa-pause-circle mr-1"></i>Nonaktif
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Type Badge -->
                                <div class="mb-3">
                                    @php
                                        $typeColors = [
                                            'skripsi' => 'bg-purple-100 text-purple-700',
                                            'proposal' => 'bg-blue-100 text-blue-700',
                                            'tugas_akhir' => 'bg-indigo-100 text-indigo-700',
                                            'laporan_praktikum' => 'bg-pink-100 text-pink-700',
                                            'makalah' => 'bg-yellow-100 text-yellow-700',
                                            'lainnya' => 'bg-gray-100 text-gray-700',
                                        ];
                                        $typeLabels = [
                                            'skripsi' => 'Skripsi',
                                            'proposal' => 'Proposal',
                                            'tugas_akhir' => 'Tugas Akhir',
                                            'laporan_praktikum' => 'Laporan Praktikum',
                                            'makalah' => 'Makalah',
                                            'lainnya' => 'Lainnya',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $typeColors[$template->type] ?? 'bg-gray-100 text-gray-700' }}">
                                        <i
                                            class="fas fa-tag mr-1.5"></i>{{ $typeLabels[$template->type] ?? ucfirst($template->type) }}
                                    </span>
                                </div>

                                <!-- Description -->
                                @if ($template->description)
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $template->description }}</p>
                                @else
                                    <p class="text-sm text-gray-400 italic">Tidak ada deskripsi</p>
                                @endif
                            </div>

                            <!-- Stats -->
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-download mr-2 text-blue-500"></i>
                                        <span
                                            class="font-semibold">{{ number_format($template->download_count) }}</span>
                                        <span class="ml-1">unduhan</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                                        <span>{{ $template->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="p-4 bg-white flex items-center space-x-2">
                                <a href="{{ route('admin.templates.show', $template) }}"
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 text-center text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                                <a href="{{ route('admin.templates.edit', $template) }}"
                                    class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-all duration-200 text-center text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button onclick="deleteTemplate({{ $template->id }})"
                                    class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-all duration-200 text-sm font-medium">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    {{ $templates->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Template</h3>
                    <p class="text-gray-600 mb-6">Belum ada template yang dibuat atau tidak ada hasil yang sesuai
                        dengan filter Anda.</p>
                    <a href="{{ route('admin.templates.create') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium">
                        <i class="fas fa-plus mr-2"></i>Buat Template Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Hapus Template?</h3>
                <p class="text-gray-600 text-center mb-6">Template yang dihapus tidak dapat dikembalikan. Yakin ingin
                    melanjutkan?</p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition-all duration-200 font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function deleteTemplate(id) {
                const modal = document.getElementById('deleteModal');
                const form = document.getElementById('deleteForm');
                form.action = `/admin/templates/${id}`;
                modal.classList.remove('hidden');
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.add('hidden');
            }

            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });

            // Close modal on outside click
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <a href="{{ route('admin.templates.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-file-alt text-blue-600 mr-3"></i>Detail Template
                    </h2>
                </div>
                <p class="text-gray-600 ml-11">{{ $template->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.templates.builder', $template) }}"
                    class="bg-purple-600 text-white px-5 py-2.5 rounded-lg hover:bg-purple-700 transition-all duration-200 flex items-center space-x-2 shadow-lg">
                    <i class="fas fa-tools"></i>
                    <span>Builder</span>
                </a>
                <a href="{{ route('admin.templates.edit', $template) }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center space-x-2 shadow-lg">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Template
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Nama Template</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $template->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Tipe Dokumen</p>
                                    @php
                                        $typeLabels = [
                                            'skripsi' => 'Skripsi',
                                            'proposal' => 'Proposal',
                                            'tugas_akhir' => 'Tugas Akhir',
                                            'laporan_praktikum' => 'Laporan Praktikum',
                                            'makalah' => 'Makalah',
                                            'lainnya' => 'Lainnya',
                                        ];
                                    @endphp
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $typeLabels[$template->type] ?? ucfirst($template->type) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Fakultas</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $template->faculty->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Program Studi</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $template->programStudy ? $template->programStudy->name : 'Semua Program Studi' }}
                                    </p>
                                </div>
                            </div>

                            @if ($template->description)
                                <div class="pt-4 border-t border-gray-100">
                                    <p class="text-sm text-gray-500 mb-2">Deskripsi</p>
                                    <p class="text-gray-700">{{ $template->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Template Rules -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-cog mr-2"></i>Aturan Template
                            </h3>
                        </div>
                        <div class="p-6">
                            <!-- Formatting Rules -->
                            @if (isset($rules['formatting']))
                                <div class="mb-6">
                                    <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                                        <i class="fas fa-font text-blue-600 mr-2"></i>Format Dokumen
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        @if (isset($rules['formatting']['font']))
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <p class="text-sm text-gray-500 mb-2">Font</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $rules['formatting']['font']['name'] ?? 'Times New Roman' }}
                                                    ({{ $rules['formatting']['font']['size'] ?? 12 }}pt)
                                                </p>
                                            </div>
                                        @endif
                                        @if (isset($rules['formatting']['page_size']))
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <p class="text-sm text-gray-500 mb-2">Ukuran Kertas</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ strtoupper($rules['formatting']['page_size']) }}</p>
                                            </div>
                                        @endif
                                        @if (isset($rules['formatting']['orientation']))
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <p class="text-sm text-gray-500 mb-2">Orientasi</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ ucfirst($rules['formatting']['orientation']) }}</p>
                                            </div>
                                        @endif
                                        @if (isset($rules['formatting']['font']['line_spacing']))
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <p class="text-sm text-gray-500 mb-2">Spasi Baris</p>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $rules['formatting']['font']['line_spacing'] }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if (isset($rules['formatting']['margins']))
                                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-500 mb-2">Margin (cm)</p>
                                            <div class="grid grid-cols-4 gap-3 mt-2">
                                                <div class="text-center">
                                                    <p class="text-xs text-gray-500">Atas</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $rules['formatting']['margins']['top'] ?? 3 }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs text-gray-500">Bawah</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $rules['formatting']['margins']['bottom'] ?? 3 }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs text-gray-500">Kiri</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $rules['formatting']['margins']['left'] ?? 4 }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs text-gray-500">Kanan</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $rules['formatting']['margins']['right'] ?? 3 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Sections -->
                            @if (isset($rules['sections']) && count($rules['sections']) > 0)
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                                        <i class="fas fa-list text-green-600 mr-2"></i>Struktur Dokumen
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($rules['sections'] as $index => $section)
                                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center space-x-2 mb-2">
                                                            <span
                                                                class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-bold">
                                                                {{ $index + 1 }}
                                                            </span>
                                                            <p class="font-bold text-gray-900">
                                                                {{ $section['title'] ?? 'Untitled Section' }}</p>
                                                        </div>
                                                        @if (isset($section['description']))
                                                            <p class="text-sm text-gray-600 ml-10">
                                                                {{ $section['description'] }}</p>
                                                        @endif
                                                    </div>
                                                    @if (isset($section['required']) && $section['required'])
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                            Wajib
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-info-circle text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Belum ada struktur dokumen yang ditambahkan</p>
                                    <a href="{{ route('admin.templates.builder', $template) }}"
                                        class="inline-block mt-4 text-blue-600 hover:text-blue-700 font-medium">
                                        Tambahkan di Builder <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-toggle-on mr-2"></i>Status
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status Template</span>
                                @if ($template->is_active)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                        <i class="fas fa-check-circle mr-1.5"></i>Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-700">
                                        <i class="fas fa-pause-circle mr-1.5"></i>Nonaktif
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route('admin.templates.toggle-active', $template) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2.5 rounded-lg font-medium transition-all duration-200
                                    {{ $template->is_active ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-green-600 text-white hover:bg-green-700' }}">
                                    <i class="fas fa-{{ $template->is_active ? 'pause' : 'play' }} mr-2"></i>
                                    {{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>Statistik
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-download text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Unduhan</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ number_format($template->download_count) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Dokumen Dicek</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ number_format($template->documentChecks->count()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @if ($template->template_file)
                                <a href="{{ route('admin.templates.download', $template) }}"
                                    class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium">
                                    <i class="fas fa-download"></i>
                                    <span>Download Template</span>
                                </a>
                            @endif

                            <form action="{{ route('admin.templates.regenerate', $template) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 font-medium">
                                    <i class="fas fa-sync-alt"></i>
                                    <span>Regenerate Dokumen</span>
                                </button>
                            </form>

                            <button onclick="deleteTemplate()"
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-medium">
                                <i class="fas fa-trash"></i>
                                <span>Hapus Template</span>
                            </button>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Dibuat</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $template->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Diperbarui</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $template->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4"
        style="display: none;">
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
                    <form action="{{ route('admin.templates.destroy', $template) }}" method="POST" class="flex-1">
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
            function deleteTemplate() {
                document.getElementById('deleteModal').style.display = 'flex';
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').style.display = 'none';
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

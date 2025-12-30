<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <a href="{{ route('admin.templates.show', $template) }}"
                        class="text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-tools text-purple-600 mr-2"></i>Template Builder
                    </h2>
                </div>
                <p class="text-gray-600 text-sm ml-11">{{ $template->name }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="previewTemplate()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium">
                    <i class="fas fa-eye mr-1"></i>Preview
                </button>
                <button onclick="saveTemplate()"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium">
                    <i class="fas fa-save mr-1"></i>Simpan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- Left Panel - Configuration -->
                <div class="lg:col-span-1 space-y-4">

                    <!-- Document Formatting -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 rounded-t-lg">
                            <h3 class="text-sm font-bold text-white flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>Format Dokumen
                            </h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <!-- Font Settings -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Font</label>
                                <select id="fontName"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Arial">Arial</option>
                                    <option value="Calibri">Calibri</option>
                                    <option value="Georgia">Georgia</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Ukuran</label>
                                    <input type="number" id="fontSize" min="8" max="72"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Spasi</label>
                                    <select id="lineSpacing"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="1">1.0</option>
                                        <option value="1.15">1.15</option>
                                        <option value="1.5">1.5</option>
                                        <option value="2">2.0</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Page Settings -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kertas</label>
                                    <select id="pageSize"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="A4">A4</option>
                                        <option value="Letter">Letter</option>
                                        <option value="Legal">Legal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Orientasi</label>
                                    <select id="orientation"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="portrait">Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Margins -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Margin (cm)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" id="marginTop" placeholder="Atas" min="0"
                                            step="0.5"
                                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <input type="number" id="marginBottom" placeholder="Bawah" min="0"
                                            step="0.5"
                                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <input type="number" id="marginLeft" placeholder="Kiri" min="0"
                                            step="0.5"
                                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <input type="number" id="marginRight" placeholder="Kanan" min="0"
                                            step="0.5"
                                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add/Edit Section -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 py-3 rounded-t-lg">
                            <h3 class="text-sm font-bold text-white flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i><span id="formTitle">Tambah Bagian</span>
                            </h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <input type="hidden" id="editingIndex" value="-1">

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Bagian</label>
                                <input type="text" id="sectionTitle" placeholder="Contoh: BAB I PENDAHULUAN"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="sectionDescription" rows="2" placeholder="Jelaskan bagian ini..."
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"></textarea>
                            </div>

                            <!-- Components -->
                            <div class="border-t pt-3">
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-puzzle-piece mr-1"></i>Komponen Bagian
                                </label>

                                <!-- Heading Settings -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-2">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Format Judul Utama</p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select id="headingFontSize"
                                                class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-green-500">
                                                <option value="12">12pt</option>
                                                <option value="14" selected>14pt</option>
                                                <option value="16">16pt</option>
                                                <option value="18">18pt</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select id="headingAlignment"
                                                class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-green-500">
                                                <option value="left">Kiri</option>
                                                <option value="center" selected>Tengah</option>
                                                <option value="right">Kanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <input type="checkbox" id="headingBold" checked
                                            class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                        <label class="text-xs text-gray-700">Bold</label>
                                        <input type="checkbox" id="headingUppercase"
                                            class="w-3 h-3 text-green-600 border-gray-300 rounded ml-2">
                                        <label class="text-xs text-gray-700">UPPERCASE</label>
                                    </div>
                                </div>

                                <!-- Subheading Hierarchy -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs font-semibold text-gray-700">
                                            <i class="fas fa-layer-group mr-1"></i>Hierarki Sub-Judul
                                        </p>
                                        <button type="button" onclick="openHeadingManager()"
                                            class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700 transition">
                                            <i class="fas fa-edit mr-1"></i>Kelola
                                        </button>
                                    </div>

                                    <!-- Heading 1 (H1) -->
                                    <div class="bg-white rounded p-2 mb-2 border border-gray-200">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-semibold text-gray-700">Heading 1 (1., 2.,
                                                3.)</span>
                                            <input type="checkbox" id="enableH1"
                                                class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="grid grid-cols-3 gap-1" id="h1Settings" style="display: none;">
                                            <select id="h1FontSize"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="11">11pt</option>
                                                <option value="12" selected>12pt</option>
                                                <option value="13">13pt</option>
                                                <option value="14">14pt</option>
                                            </select>
                                            <select id="h1Style"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="normal">Normal</option>
                                                <option value="bold" selected>Bold</option>
                                                <option value="italic">Italic</option>
                                            </select>
                                            <select id="h1Align"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="left" selected>Kiri</option>
                                                <option value="center">Tengah</option>
                                                <option value="right">Kanan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Heading 2 (H2) -->
                                    <div class="bg-white rounded p-2 mb-2 border border-gray-200">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-semibold text-gray-700">Heading 2 (1.1,
                                                1.2)</span>
                                            <input type="checkbox" id="enableH2"
                                                class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="grid grid-cols-3 gap-1" id="h2Settings" style="display: none;">
                                            <select id="h2FontSize"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="11">11pt</option>
                                                <option value="12" selected>12pt</option>
                                                <option value="13">13pt</option>
                                            </select>
                                            <select id="h2Style"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="normal">Normal</option>
                                                <option value="bold" selected>Bold</option>
                                                <option value="italic">Italic</option>
                                            </select>
                                            <select id="h2Align"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="left" selected>Kiri</option>
                                                <option value="center">Tengah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Heading 3 (H3) -->
                                    <div class="bg-white rounded p-2 border border-gray-200">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-semibold text-gray-700">Heading 3 (1.1.1)</span>
                                            <input type="checkbox" id="enableH3"
                                                class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="grid grid-cols-3 gap-1" id="h3Settings" style="display: none;">
                                            <select id="h3FontSize"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="11">11pt</option>
                                                <option value="12" selected>12pt</option>
                                            </select>
                                            <select id="h3Style"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="normal" selected>Normal</option>
                                                <option value="bold">Bold</option>
                                                <option value="italic">Italic</option>
                                            </select>
                                            <select id="h3Align"
                                                class="px-2 py-1 text-xs border border-gray-300 rounded">
                                                <option value="left" selected>Kiri</option>
                                                <option value="center">Tengah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <p class="text-xs text-gray-500 mt-2 italic">
                                        <i class="fas fa-info-circle mr-1"></i>Klik "Kelola" untuk menambah konten
                                        heading
                                    </p>
                                </div>

                                <!-- Content Settings -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-2">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Format Konten</p>
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" id="hasNumbering"
                                                class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                            <span class="text-xs text-gray-700">Gunakan Penomoran</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" id="hasIndentation" checked
                                                class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                            <span class="text-xs text-gray-700">Indentasi Paragraf</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" id="allowImages"
                                                class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                            <span class="text-xs text-gray-700">Izinkan Gambar</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" id="allowTables"
                                                class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                            <span class="text-xs text-gray-700">Izinkan Tabel</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Page Break -->
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" id="pageBreakBefore"
                                            class="w-3 h-3 text-green-600 border-gray-300 rounded">
                                        <span class="text-xs text-gray-700">Page Break Sebelum Bagian</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 pt-2 border-t">
                                <input type="checkbox" id="sectionRequired"
                                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                                <label for="sectionRequired" class="text-xs text-gray-700 font-semibold">Bagian
                                    Wajib</label>
                            </div>

                            <div class="flex space-x-2">
                                <button onclick="saveSection()"
                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium">
                                    <i class="fas fa-save mr-2"></i><span id="saveButtonText">Tambahkan</span>
                                </button>
                                <button onclick="cancelEdit()" id="cancelButton" style="display: none;"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-all duration-200 text-sm font-medium">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                        <h4 class="text-xs font-bold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-magic mr-2 text-purple-600"></i>Template Cepat
                        </h4>
                        <div class="space-y-2">
                            <button onclick="loadSkripsiTemplate()"
                                class="w-full bg-purple-50 text-purple-700 px-3 py-2 rounded-lg hover:bg-purple-100 transition text-xs font-medium text-left">
                                <i class="fas fa-book mr-2"></i>Template Skripsi
                            </button>
                            <button onclick="loadProposalTemplate()"
                                class="w-full bg-blue-50 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-100 transition text-xs font-medium text-left">
                                <i class="fas fa-file-alt mr-2"></i>Template Proposal
                            </button>
                            <button onclick="clearAllSections()"
                                class="w-full bg-red-50 text-red-700 px-3 py-2 rounded-lg hover:bg-red-100 transition text-xs font-medium text-left">
                                <i class="fas fa-trash mr-2"></i>Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Sections Preview -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div
                            class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3 rounded-t-lg flex items-center justify-between">
                            <h3 class="text-sm font-bold text-white flex items-center">
                                <i class="fas fa-list mr-2"></i>Struktur Dokumen
                            </h3>
                            <span id="sectionCount"
                                class="bg-white bg-opacity-20 px-2 py-1 rounded text-xs font-semibold">0 Bagian</span>
                        </div>

                        <div class="p-4">
                            <div id="sectionsContainer" class="space-y-2 min-h-[400px]">
                                <div class="text-center py-12 text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p class="text-sm">Belum ada bagian yang ditambahkan</p>
                                    <p class="text-xs mt-1">Gunakan form di sebelah kiri atau template cepat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Active Toggle -->
            <div class="mt-4 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" id="isActive" {{ $template->is_active ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-700">Aktifkan Template Setelah Menyimpan</span>
                        <p class="text-xs text-gray-500">Template aktif dapat digunakan oleh mahasiswa</p>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- Heading Manager Modal -->
    <div id="headingManagerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl max-h-screen overflow-y-auto">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                    <h3 class="text-lg font-bold">
                        <i class="fas fa-list-ol mr-2"></i>Kelola Konten Heading - <span
                            id="headingManagerTitle"></span>
                    </h3>
                    <button onclick="closeHeadingManager()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6">
                    <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Petunjuk:</strong> Tambahkan item heading yang akan muncul di section ini.
                            Contoh: "1.1 Latar Belakang", "1.2 Rumusan Masalah", dll.
                        </p>
                    </div>

                    <!-- Add Heading Item Form -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Item Heading
                        </h4>
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Level</label>
                                <select id="newHeadingLevel"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                                    <option value="h1">H1</option>
                                    <option value="h2">H2</option>
                                    <option value="h3">H3</option>
                                </select>
                            </div>
                            <div class="col-span-7">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Judul Heading</label>
                                <input type="text" id="newHeadingTitle"
                                    placeholder="Contoh: Latar Belakang Masalah"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-3 flex items-end">
                                <button type="button" onclick="addHeadingItem()"
                                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                                    <i class="fas fa-plus mr-2"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Heading Items List -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">
                                <i class="fas fa-list mr-2"></i>Daftar Heading (<span id="headingCount">0</span> item)
                            </h4>
                            <button type="button" onclick="clearAllHeadings()"
                                class="text-xs text-red-600 hover:text-red-700">
                                <i class="fas fa-trash mr-1"></i>Hapus Semua
                            </button>
                        </div>
                        <div id="headingItemsList" class="space-y-2 max-h-96 overflow-y-auto">
                            <!-- Will be populated dynamically -->
                        </div>
                        <div id="emptyHeadingState" class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p class="text-sm">Belum ada heading ditambahkan</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeHeadingManager()"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Tutup
                        </button>
                        <button type="button" onclick="saveHeadings()"
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Heading
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Management Modal -->
    <div id="contentManagerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl max-h-screen overflow-y-auto">
                <div
                    class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                    <h3 class="text-lg font-bold">
                        <i class="fas fa-file-alt mr-2"></i>Kelola Konten - <span id="contentManagerTitle"></span>
                    </h3>
                    <button onclick="closeContentManager()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <ul class="flex space-x-4" role="tablist">
                            <li>
                                <button onclick="switchContentTab('main')" id="mainContentTab"
                                    class="content-tab px-4 py-2 text-sm font-semibold border-b-2 border-purple-600 text-purple-600">
                                    <i class="fas fa-file-text mr-2"></i>Konten Utama
                                </button>
                            </li>
                            <li>
                                <button onclick="switchContentTab('headings')" id="headingsContentTab"
                                    class="content-tab px-4 py-2 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-list-ol mr-2"></i>Heading Items
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Main Content Tab -->
                    <div id="mainContentTabPanel" class="content-tab-panel">
                        <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Konten Utama Section:</strong> Tulis konten pembuka atau penjelasan umum untuk
                                section ini.
                            </p>
                        </div>

                        <!-- Rich Text Editor for Main Content -->
                        <div class="bg-white border border-gray-300 rounded-lg">
                            <div id="mainContentEditor" class="min-h-[300px]"></div>
                        </div>
                    </div>

                    <!-- Headings Content Tab -->
                    <div id="headingsContentTabPanel" class="content-tab-panel" style="display: none;">
                        <div class="mb-4 bg-purple-50 border border-purple-200 rounded-lg p-3">
                            <p class="text-sm text-purple-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Heading Items:</strong> Kelola sub-bagian dari section ini. Setiap heading dapat
                                memiliki konten sendiri.
                            </p>
                        </div>

                        <!-- Add Heading Form -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Heading Baru
                            </h4>
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Level</label>
                                    <select id="contentHeadingLevel"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                                        <option value="h1">H1</option>
                                        <option value="h2">H2</option>
                                        <option value="h3">H3</option>
                                    </select>
                                </div>
                                <div class="col-span-7">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Judul Heading</label>
                                    <input type="text" id="contentHeadingTitle"
                                        placeholder="Contoh: 1.1 Latar Belakang"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div class="col-span-3 flex items-end">
                                    <button type="button" onclick="addContentHeading()"
                                        class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                                        <i class="fas fa-plus mr-2"></i>Tambah
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Headings List -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-700">
                                    <i class="fas fa-list mr-2"></i>Daftar Heading (<span
                                        id="contentHeadingCount">0</span> item)
                                </h4>
                                <button type="button" onclick="clearAllContentHeadings()"
                                    class="text-xs text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash mr-1"></i>Hapus Semua
                                </button>
                            </div>
                            <div id="contentHeadingsList" class="space-y-2 max-h-96 overflow-y-auto">
                                <!-- Will be populated dynamically -->
                            </div>
                            <div id="emptyContentHeadingState" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-2"></i>
                                <p class="text-sm">Belum ada heading ditambahkan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeContentManager()"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Tutup
                        </button>
                        <button type="button" onclick="saveContentManager()"
                            class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Konten
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Heading Content Editor Modal -->
    <div id="headingContentEditorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl max-h-screen overflow-y-auto">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                    <h3 class="text-lg font-bold">
                        <i class="fas fa-edit mr-2"></i>Edit Konten Heading - <span id="headingEditorTitle"></span>
                    </h3>
                    <button onclick="closeHeadingContentEditor()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6">
                    <div class="mb-4 bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                        <p class="text-sm text-indigo-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Gunakan editor di bawah untuk menulis konten detail dari heading ini.
                        </p>
                    </div>

                    <!-- Rich Text Editor for Heading Content -->
                    <div class="bg-white border border-gray-300 rounded-lg">
                        <div id="headingContentEditor" class="min-h-[400px]"></div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeHeadingContentEditor()"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="button" onclick="saveHeadingContent()"
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Konten
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <!-- Quill Editor CSS -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .ql-editor {
                min-height: 250px;
                font-size: 14px;
            }

            .content-tab.active {
                border-bottom-color: #9333ea;
                color: #9333ea;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Quill Editor JS -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <!-- SortableJS -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

        <script>
            let sections = [];

            // Load existing template rules
            const currentRules = @json($currentRules);

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                loadCurrentRules();
                setupHeadingToggles();
            });

            // Setup heading toggles
            function setupHeadingToggles() {
                const headings = ['H1', 'H2', 'H3'];

                headings.forEach(h => {
                    const checkbox = document.getElementById(`enable${h}`);
                    const settings = document.getElementById(`${h.toLowerCase()}Settings`);

                    checkbox.addEventListener('change', function() {
                        settings.style.display = this.checked ? 'grid' : 'none';
                    });
                });
            }

            function loadCurrentRules() {
                // Load formatting
                if (currentRules.formatting) {
                    const fmt = currentRules.formatting;

                    if (fmt.font) {
                        document.getElementById('fontName').value = fmt.font.name || 'Times New Roman';
                        document.getElementById('fontSize').value = fmt.font.size || 12;
                        document.getElementById('lineSpacing').value = fmt.font.line_spacing || 1.5;
                    }

                    document.getElementById('pageSize').value = fmt.page_size || 'A4';
                    document.getElementById('orientation').value = fmt.orientation || 'portrait';

                    if (fmt.margins) {
                        document.getElementById('marginTop').value = fmt.margins.top || 3;
                        document.getElementById('marginBottom').value = fmt.margins.bottom || 3;
                        document.getElementById('marginLeft').value = fmt.margins.left || 4;
                        document.getElementById('marginRight').value = fmt.margins.right || 3;
                    }
                }

                // Load sections
                if (currentRules.sections && Array.isArray(currentRules.sections)) {
                    sections = currentRules.sections;
                    renderSections();
                }
            }

            function getSectionData() {
                const subheadings = {};

                // Collect H1 settings
                if (document.getElementById('enableH1').checked) {
                    subheadings.h1 = {
                        enabled: true,
                        fontSize: parseInt(document.getElementById('h1FontSize').value),
                        style: document.getElementById('h1Style').value,
                        alignment: document.getElementById('h1Align').value
                    };
                }

                // Collect H2 settings
                if (document.getElementById('enableH2').checked) {
                    subheadings.h2 = {
                        enabled: true,
                        fontSize: parseInt(document.getElementById('h2FontSize').value),
                        style: document.getElementById('h2Style').value,
                        alignment: document.getElementById('h2Align').value
                    };
                }

                // Collect H3 settings
                if (document.getElementById('enableH3').checked) {
                    subheadings.h3 = {
                        enabled: true,
                        fontSize: parseInt(document.getElementById('h3FontSize').value),
                        style: document.getElementById('h3Style').value,
                        alignment: document.getElementById('h3Align').value
                    };
                }

                return {
                    title: document.getElementById('sectionTitle').value.trim(),
                    description: document.getElementById('sectionDescription').value.trim(),
                    required: document.getElementById('sectionRequired').checked,
                    components: {
                        heading: {
                            fontSize: parseInt(document.getElementById('headingFontSize').value),
                            alignment: document.getElementById('headingAlignment').value,
                            bold: document.getElementById('headingBold').checked,
                            uppercase: document.getElementById('headingUppercase').checked
                        },
                        subheadings: subheadings,
                        content: {
                            hasNumbering: document.getElementById('hasNumbering').checked,
                            hasIndentation: document.getElementById('hasIndentation').checked,
                            allowImages: document.getElementById('allowImages').checked,
                            allowTables: document.getElementById('allowTables').checked
                        },
                        pageBreakBefore: document.getElementById('pageBreakBefore').checked
                    }
                };
            }

            function clearSectionForm() {
                document.getElementById('sectionTitle').value = '';
                document.getElementById('sectionDescription').value = '';
                document.getElementById('sectionRequired').checked = false;

                // Reset to defaults
                document.getElementById('headingFontSize').value = '14';
                document.getElementById('headingAlignment').value = 'center';
                document.getElementById('headingBold').checked = true;
                document.getElementById('headingUppercase').checked = false;

                // Reset subheadings
                ['H1', 'H2', 'H3'].forEach(h => {
                    document.getElementById(`enable${h}`).checked = false;
                    document.getElementById(`${h.toLowerCase()}Settings`).style.display = 'none';
                });

                // Reset subheading values to defaults
                document.getElementById('h1FontSize').value = '12';
                document.getElementById('h1Style').value = 'bold';
                document.getElementById('h1Align').value = 'left';
                document.getElementById('h2FontSize').value = '12';
                document.getElementById('h2Style').value = 'bold';
                document.getElementById('h2Align').value = 'left';
                document.getElementById('h3FontSize').value = '12';
                document.getElementById('h3Style').value = 'normal';
                document.getElementById('h3Align').value = 'left';

                document.getElementById('hasNumbering').checked = false;
                document.getElementById('hasIndentation').checked = true;
                document.getElementById('allowImages').checked = false;
                document.getElementById('allowTables').checked = false;
                document.getElementById('pageBreakBefore').checked = false;

                document.getElementById('editingIndex').value = '-1';
                document.getElementById('formTitle').textContent = 'Tambah Bagian';
                document.getElementById('saveButtonText').textContent = 'Tambahkan';
                document.getElementById('cancelButton').style.display = 'none';
            }

            function saveSection() {
                const sectionData = getSectionData();
                const editingIndex = parseInt(document.getElementById('editingIndex').value);

                if (!sectionData.title) {
                    showAlert('Judul bagian harus diisi!', 'error');
                    return;
                }

                if (editingIndex >= 0) {
                    // Update existing section
                    sections[editingIndex] = {
                        ...sectionData,
                        order: editingIndex + 1
                    };
                    showAlert('Bagian berhasil diupdate!', 'success');
                } else {
                    // Add new section
                    sections.push({
                        ...sectionData,
                        order: sections.length + 1
                    });
                    showAlert('Bagian berhasil ditambahkan!', 'success');
                }

                clearSectionForm();
                renderSections();
            }

            function cancelEdit() {
                clearSectionForm();
            }

            function renderSections() {
                const container = document.getElementById('sectionsContainer');
                const countSpan = document.getElementById('sectionCount');

                countSpan.textContent = `${sections.length} Bagian`;

                if (sections.length === 0) {
                    container.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p class="text-sm">Belum ada bagian yang ditambahkan</p>
                        <p class="text-xs mt-1">Gunakan form di sebelah kiri atau template cepat</p>
                    </div>
                `;
                    return;
                }

                container.innerHTML = sections.map((section, index) => {
                    const components = section.components || {};
                    const heading = components.heading || {};
                    const content = components.content || {};
                    const subheadings = components.subheadings || {};

                    let componentBadges = [];
                    if (heading.bold) componentBadges.push(
                        '<span class="text-xs bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">Bold</span>');
                    if (heading.uppercase) componentBadges.push(
                        '<span class="text-xs bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">UPPER</span>');

                    // Subheading badges
                    if (subheadings.h1 && subheadings.h1.enabled) componentBadges.push(
                        '<span class="text-xs bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded">H1</span>');
                    if (subheadings.h2 && subheadings.h2.enabled) componentBadges.push(
                        '<span class="text-xs bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded">H2</span>');
                    if (subheadings.h3 && subheadings.h3.enabled) componentBadges.push(
                        '<span class="text-xs bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded">H3</span>');

                    if (content.hasNumbering) componentBadges.push(
                        '<span class="text-xs bg-green-100 text-green-700 px-1.5 py-0.5 rounded">Nomor</span>');
                    if (content.allowImages) componentBadges.push(
                        '<span class="text-xs bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded">Gambar</span>');
                    if (content.allowTables) componentBadges.push(
                        '<span class="text-xs bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded">Tabel</span>');
                    if (components.pageBreakBefore) componentBadges.push(
                        '<span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded">Page Break</span>'
                    );

                    return `
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 hover:shadow-md transition-all duration-200" draggable="true" ondragstart="drag(event, ${index})" ondragover="allowDrop(event)" ondrop="drop(event, ${index})">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <div class="flex flex-col items-center space-y-1">
                                <button onclick="moveUp(${index})" class="text-gray-400 hover:text-blue-600 transition" ${index === 0 ? 'disabled' : ''}>
                                    <i class="fas fa-chevron-up text-xs"></i>
                                </button>
                                <span class="w-7 h-7 bg-purple-600 text-white rounded-lg flex items-center justify-center text-xs font-bold">
                                    ${index + 1}
                                </span>
                                <button onclick="moveDown(${index})" class="text-gray-400 hover:text-blue-600 transition" ${index === sections.length - 1 ? 'disabled' : ''}>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <h4 class="font-bold text-gray-900 text-sm">${section.title}</h4>
                                    ${section.required ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-700">Wajib</span>' : ''}
                                </div>
                                ${section.description ? `<p class="text-xs text-gray-600 mb-2">${section.description}</p>` : ''}
                                ${componentBadges.length > 0 ? `
                                                            <div class="flex flex-wrap gap-1 mt-2">
                                                                <span class="text-xs text-gray-500"><i class="fas fa-puzzle-piece mr-1"></i></span>
                                                                ${componentBadges.join('')}
                                                            </div>
                                                        ` : ''}
                                ${section.headingItems && section.headingItems.length > 0 ? `
                                                            <div class="flex items-center gap-1 mt-2">
                                                                <span class="text-xs text-gray-500"><i class="fas fa-list-ol mr-1"></i></span>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                                    ${section.headingItems.length} Heading
                                                                </span>
                                                            </div>
                                                        ` : ''}
                                ${heading.fontSize || heading.alignment ? `
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                <i class="fas fa-font mr-1"></i>${heading.fontSize || 14}pt • ${heading.alignment === 'center' ? 'Tengah' : heading.alignment === 'left' ? 'Kiri' : 'Kanan'}
                                                            </div>
                                                        ` : ''}
                            </div>
                        </div>
                        <div class="flex items-center space-x-1 ml-2">
                            <button onclick="editSection(${index})" class="text-blue-600 hover:text-blue-700 p-1.5 hover:bg-blue-50 rounded transition" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button onclick="manageSectionContent(${index})" class="text-purple-600 hover:text-purple-700 p-1.5 hover:bg-purple-50 rounded transition" title="Kelola Konten">
                                <i class="fas fa-file-alt text-xs"></i>
                            </button>
                            <button onclick="duplicateSection(${index})" class="text-green-600 hover:text-green-700 p-1.5 hover:bg-green-50 rounded transition" title="Duplikat">
                                <i class="fas fa-copy text-xs"></i>
                            </button>
                            <button onclick="deleteSection(${index})" class="text-red-600 hover:text-red-700 p-1.5 hover:bg-red-50 rounded transition" title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                }).join('');
            }

            function moveUp(index) {
                if (index === 0) return;
                [sections[index], sections[index - 1]] = [sections[index - 1], sections[index]];
                renderSections();
            }

            function moveDown(index) {
                if (index === sections.length - 1) return;
                [sections[index], sections[index + 1]] = [sections[index + 1], sections[index]];
                renderSections();
            }

            function editSection(index) {
                const section = sections[index];

                // Fill basic info
                document.getElementById('sectionTitle').value = section.title;
                document.getElementById('sectionDescription').value = section.description || '';
                document.getElementById('sectionRequired').checked = section.required || false;

                // Fill component settings
                if (section.components) {
                    if (section.components.heading) {
                        document.getElementById('headingFontSize').value = section.components.heading.fontSize || 14;
                        document.getElementById('headingAlignment').value = section.components.heading.alignment || 'center';
                        document.getElementById('headingBold').checked = section.components.heading.bold !== false;
                        document.getElementById('headingUppercase').checked = section.components.heading.uppercase || false;
                    }

                    // Load subheadings
                    if (section.components.subheadings) {
                        const subheadings = section.components.subheadings;

                        ['h1', 'h2', 'h3'].forEach(h => {
                            const upper = h.toUpperCase();
                            if (subheadings[h] && subheadings[h].enabled) {
                                document.getElementById(`enable${upper}`).checked = true;
                                document.getElementById(`${h}Settings`).style.display = 'grid';
                                document.getElementById(`${h}FontSize`).value = subheadings[h].fontSize || 12;
                                document.getElementById(`${h}Style`).value = subheadings[h].style || 'normal';
                                document.getElementById(`${h}Align`).value = subheadings[h].alignment || 'left';
                            } else {
                                document.getElementById(`enable${upper}`).checked = false;
                                document.getElementById(`${h}Settings`).style.display = 'none';
                            }
                        });
                    }

                    if (section.components.content) {
                        document.getElementById('hasNumbering').checked = section.components.content.hasNumbering || false;
                        document.getElementById('hasIndentation').checked = section.components.content.hasIndentation !== false;
                        document.getElementById('allowImages').checked = section.components.content.allowImages || false;
                        document.getElementById('allowTables').checked = section.components.content.allowTables || false;
                    }

                    document.getElementById('pageBreakBefore').checked = section.components.pageBreakBefore || false;
                }

                // Set editing mode
                document.getElementById('editingIndex').value = index;
                document.getElementById('formTitle').textContent = 'Edit Bagian';
                document.getElementById('saveButtonText').textContent = 'Update';
                document.getElementById('cancelButton').style.display = 'block';

                // Scroll to form
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function deleteSection(index) {
                if (confirm('Hapus bagian ini?')) {
                    sections.splice(index, 1);
                    renderSections();
                    showAlert('Bagian berhasil dihapus!', 'success');
                }
            }

            function duplicateSection(index) {
                const section = {
                    ...sections[index]
                };
                section.title = section.title + ' (Copy)';
                section.order = sections.length + 1;
                sections.push(section);
                renderSections();
                showAlert('Bagian berhasil diduplikat!', 'success');
            }

            function clearAllSections() {
                if (sections.length === 0) return;

                if (confirm('Hapus semua bagian? Tindakan ini tidak dapat dibatalkan.')) {
                    sections = [];
                    renderSections();
                    showAlert('Semua bagian berhasil dihapus!', 'success');
                }
            }

            // Drag and drop
            let draggedIndex = null;

            function drag(event, index) {
                draggedIndex = index;
                event.dataTransfer.effectAllowed = 'move';
            }

            function allowDrop(event) {
                event.preventDefault();
            }

            function drop(event, dropIndex) {
                event.preventDefault();
                if (draggedIndex !== null && draggedIndex !== dropIndex) {
                    const draggedItem = sections[draggedIndex];
                    sections.splice(draggedIndex, 1);
                    sections.splice(dropIndex, 0, draggedItem);
                    renderSections();
                }
                draggedIndex = null;
            }

            // Quick Templates
            function getDefaultComponents(type = 'content') {
                if (type === 'cover') {
                    return {
                        heading: {
                            fontSize: 16,
                            alignment: 'center',
                            bold: true,
                            uppercase: true
                        },
                        subheadings: {},
                        content: {
                            hasNumbering: false,
                            hasIndentation: false,
                            allowImages: false,
                            allowTables: false
                        },
                        pageBreakBefore: false
                    };
                } else if (type === 'chapter') {
                    return {
                        heading: {
                            fontSize: 14,
                            alignment: 'center',
                            bold: true,
                            uppercase: true
                        },
                        subheadings: {
                            h1: {
                                enabled: true,
                                fontSize: 12,
                                style: 'bold',
                                alignment: 'left'
                            },
                            h2: {
                                enabled: true,
                                fontSize: 12,
                                style: 'bold',
                                alignment: 'left'
                            },
                            h3: {
                                enabled: true,
                                fontSize: 12,
                                style: 'normal',
                                alignment: 'left'
                            }
                        },
                        content: {
                            hasNumbering: false,
                            hasIndentation: true,
                            allowImages: true,
                            allowTables: true
                        },
                        pageBreakBefore: true
                    };
                } else if (type === 'list') {
                    return {
                        heading: {
                            fontSize: 14,
                            alignment: 'center',
                            bold: true,
                            uppercase: true
                        },
                        subheadings: {},
                        content: {
                            hasNumbering: true,
                            hasIndentation: false,
                            allowImages: false,
                            allowTables: false
                        },
                        pageBreakBefore: false
                    };
                } else {
                    return {
                        heading: {
                            fontSize: 14,
                            alignment: 'center',
                            bold: true,
                            uppercase: false
                        },
                        subheadings: {},
                        content: {
                            hasNumbering: false,
                            hasIndentation: true,
                            allowImages: false,
                            allowTables: false
                        },
                        pageBreakBefore: false
                    };
                }
            }

            function loadSkripsiTemplate() {
                if (sections.length > 0 && !confirm('Ini akan mengganti struktur yang ada. Lanjutkan?')) return;

                sections = [{
                        title: 'HALAMAN JUDUL',
                        description: 'Halaman cover skripsi',
                        required: true,
                        order: 1,
                        components: getDefaultComponents('cover')
                    },
                    {
                        title: 'HALAMAN PENGESAHAN',
                        description: 'Lembar pengesahan pembimbing',
                        required: true,
                        order: 2,
                        components: getDefaultComponents('cover')
                    },
                    {
                        title: 'HALAMAN PERNYATAAN',
                        description: 'Pernyataan keaslian karya',
                        required: true,
                        order: 3,
                        components: getDefaultComponents('cover')
                    },
                    {
                        title: 'ABSTRAK',
                        description: 'Ringkasan penelitian dalam bahasa Indonesia',
                        required: true,
                        order: 4,
                        components: getDefaultComponents('content')
                    },
                    {
                        title: 'ABSTRACT',
                        description: 'Ringkasan penelitian dalam bahasa Inggris',
                        required: true,
                        order: 5,
                        components: getDefaultComponents('content')
                    },
                    {
                        title: 'KATA PENGANTAR',
                        description: 'Ucapan terima kasih',
                        required: true,
                        order: 6,
                        components: getDefaultComponents('content')
                    },
                    {
                        title: 'DAFTAR ISI',
                        description: 'Daftar isi dokumen',
                        required: true,
                        order: 7,
                        components: getDefaultComponents('list')
                    },
                    {
                        title: 'DAFTAR GAMBAR',
                        description: 'Daftar gambar dan ilustrasi',
                        required: false,
                        order: 8,
                        components: getDefaultComponents('list')
                    },
                    {
                        title: 'DAFTAR TABEL',
                        description: 'Daftar tabel',
                        required: false,
                        order: 9,
                        components: getDefaultComponents('list')
                    },
                    {
                        title: 'BAB I PENDAHULUAN',
                        description: 'Latar belakang, rumusan masalah, tujuan, manfaat',
                        required: true,
                        order: 10,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB II TINJAUAN PUSTAKA',
                        description: 'Landasan teori dan penelitian terkait',
                        required: true,
                        order: 11,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB III METODOLOGI',
                        description: 'Metode penelitian',
                        required: true,
                        order: 12,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB IV HASIL DAN PEMBAHASAN',
                        description: 'Hasil penelitian dan analisis',
                        required: true,
                        order: 13,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB V PENUTUP',
                        description: 'Kesimpulan dan saran',
                        required: true,
                        order: 14,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'DAFTAR PUSTAKA',
                        description: 'Referensi yang digunakan',
                        required: true,
                        order: 15,
                        components: getDefaultComponents('list')
                    },
                    {
                        title: 'LAMPIRAN',
                        description: 'Dokumen pendukung',
                        required: false,
                        order: 16,
                        components: getDefaultComponents('content')
                    }
                ];
                renderSections();
                showAlert('Template Skripsi berhasil dimuat!', 'success');
            }

            function loadProposalTemplate() {
                if (sections.length > 0 && !confirm('Ini akan mengganti struktur yang ada. Lanjutkan?')) return;

                sections = [{
                        title: 'HALAMAN JUDUL',
                        description: 'Halaman cover proposal',
                        required: true,
                        order: 1,
                        components: getDefaultComponents('cover')
                    },
                    {
                        title: 'BAB I PENDAHULUAN',
                        description: 'Latar belakang dan rumusan masalah',
                        required: true,
                        order: 2,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB II TINJAUAN PUSTAKA',
                        description: 'Landasan teori',
                        required: true,
                        order: 3,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'BAB III METODOLOGI',
                        description: 'Metode yang akan digunakan',
                        required: true,
                        order: 4,
                        components: getDefaultComponents('chapter')
                    },
                    {
                        title: 'DAFTAR PUSTAKA',
                        description: 'Referensi',
                        required: true,
                        order: 5,
                        components: getDefaultComponents('list')
                    }
                ];
                renderSections();
                showAlert('Template Proposal berhasil dimuat!', 'success');
            }

            function previewTemplate() {
                const rules = buildTemplateRules();

                let preview = `
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <div>
                        <h4 class="font-bold mb-2">Format Dokumen:</h4>
                        <ul class="text-sm space-y-1">
                            <li><i class="fas fa-font mr-2 text-blue-600"></i>Font: ${rules.formatting.font.name} (${rules.formatting.font.size}pt)</li>
                            <li><i class="fas fa-align-justify mr-2 text-blue-600"></i>Spasi: ${rules.formatting.font.line_spacing}</li>
                            <li><i class="fas fa-file mr-2 text-blue-600"></i>Kertas: ${rules.formatting.page_size} - ${rules.formatting.orientation}</li>
                            <li><i class="fas fa-border-style mr-2 text-blue-600"></i>Margin: T:${rules.formatting.margins.top}cm B:${rules.formatting.margins.bottom}cm L:${rules.formatting.margins.left}cm R:${rules.formatting.margins.right}cm</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-2">Struktur Dokumen (${sections.length} bagian):</h4>
                        <div class="text-sm space-y-2">
                            ${sections.map((s, i) => {
                                const comp = s.components || {};
                                const heading = comp.heading || {};
                                const content = comp.content || {};
                                const subheadings = comp.subheadings || {};

                                let subheadingInfo = '';
                                if (subheadings.h1 && subheadings.h1.enabled) {
                                    subheadingInfo += `<div class="ml-10 text-xs text-gray-600 mt-1">
                                        <i class="fas fa-angle-right mr-1"></i>H1: ${subheadings.h1.fontSize}pt, ${subheadings.h1.style}, ${subheadings.h1.alignment}
                                    </div>`;
                                }
    if (subheadings.h2 && subheadings.h2.enabled) {
        subheadingInfo += `<div class="ml-10 text-xs text-gray-600">
                                                <i class="fas fa-angle-right mr-1"></i>H2: ${subheadings.h2.fontSize}pt, ${subheadings.h2.style}, ${subheadings.h2.alignment}
                                            </div>`;
    }
    if (subheadings.h3 && subheadings.h3.enabled) {
        subheadingInfo += `<div class="ml-10 text-xs text-gray-600">
                                                <i class="fas fa-angle-right mr-1"></i>H3: ${subheadings.h3.fontSize}pt, ${subheadings.h3.style}, ${subheadings.h3.alignment}
                                            </div>`;
    }

    return `
                                            <div class="border-l-3 border-purple-500 pl-3 py-1 bg-gray-50 rounded">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-bold">${i + 1}.</span>
                                                    <span class="font-semibold">${s.title}</span>
                                                    ${s.required ? '<span class="text-xs text-red-600">(Wajib)</span>' : ''}
                                                </div>
                                                ${s.description ? `<p class="text-xs text-gray-600 ml-5">${s.description}</p>` : ''}
                                                <div class="text-xs text-gray-500 ml-5 mt-1">
                                                    <span class="mr-2"><i class="fas fa-text-height"></i> ${heading.fontSize || 14}pt</span>
                                                    <span class="mr-2"><i class="fas fa-align-${heading.alignment || 'center'}"></i></span>
                                                    ${heading.bold ? '<span class="mr-2"><i class="fas fa-bold"></i></span>' : ''}
                                                    ${content.hasNumbering ? '<span class="mr-2"><i class="fas fa-list-ol"></i> Nomor</span>' : ''}
                                                    ${content.allowImages ? '<span class="mr-2"><i class="fas fa-image"></i> Gambar</span>' : ''}
                                                    ${content.allowTables ? '<span class="mr-2"><i class="fas fa-table"></i> Tabel</span>' : ''}
                                                    ${comp.pageBreakBefore ? '<span class="mr-2"><i class="fas fa-file-import"></i> Page Break</span>' : ''}
                                                </div>
                                                ${subheadingInfo}
                                                ${s.headingItems && s.headingItems.length > 0 ? `
                                            <div class="ml-10 mt-2 space-y-1">
                                                <div class="text-xs font-semibold text-indigo-700">
                                                    <i class="fas fa-list-ol mr-1"></i>Konten Heading (${s.headingItems.length} item):
                                                </div>
                                                ${s.headingItems.map(item => {
                                                    const levelColor = {
                                                        'h1': 'text-blue-600',
                                                        'h2': 'text-green-600',
                                                        'h3': 'text-purple-600'
                                                    }[item.level];
                                                    return `<div class="text-xs ${levelColor} pl-2">
                                                                <i class="fas fa-angle-right mr-1"></i>${item.level.toUpperCase()}: ${item.title}
                                                            </div>`;
                                                }).join('')}
                                            </div>
                                            ` : ''}
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>
                        </div>
                    `;

                        showAlert(preview, 'info', false);
                    }

                                function buildTemplateRules() {
                                    return {
                                        formatting: {
                                            font: {
                                                name: document.getElementById('fontName').value,
                                                size: parseInt(document.getElementById('fontSize').value) || 12,
                                                line_spacing: parseFloat(document.getElementById('lineSpacing').value) || 1.5
                                            },
                                            page_size: document.getElementById('pageSize').value,
                                            orientation: document.getElementById('orientation').value,
                                            margins: {
                                                top: parseFloat(document.getElementById('marginTop').value) || 3,
                                                bottom: parseFloat(document.getElementById('marginBottom').value) || 3,
                                                left: parseFloat(document.getElementById('marginLeft').value) || 4,
                                                right: parseFloat(document.getElementById('marginRight').value) || 3
                                            }
                                        },
                                        sections: sections
                                    };
                                }

                                async function saveTemplate() {
                                    const rules = buildTemplateRules();
                                    const isActive = document.getElementById('isActive').checked;

                                    try {
                                        const response = await fetch('{{ route('admin.templates.save-builder', $template) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                template_rules: JSON.stringify(rules),
                                                is_active: isActive
                                            })
                                        });

                                        const data = await response.json();

                                        if (data.success) {
                                            showAlert(data.message, 'success');
                                            setTimeout(() => {
                                                window.location.href = data.redirect;
                                            }, 1500);
                                        } else {
                                            showAlert(data.message, 'error');
                                        }
                                    } catch (error) {
                                        showAlert('Terjadi kesalahan saat menyimpan: ' + error.message, 'error');
                                    }
                                }

                                function showAlert(message, type = 'info', autoClose = true) {
                                    const container = document.getElementById('alertContainer');
                                    const colors = {
                                        success: 'bg-green-50 border-green-500 text-green-800',
                                        error: 'bg-red-50 border-red-500 text-red-800',
                                        info: 'bg-blue-50 border-blue-500 text-blue-800'
                                    };
                                    const icons = {
                                        success: 'fa-check-circle text-green-500',
                                        error: 'fa-exclamation-circle text-red-500',
                                        info: 'fa-info-circle text-blue-500'
                                    };

                                    const alert = document.createElement('div');
                                    alert.className = `${colors[type]} border-l-4 rounded-lg p-4 mb-4 flex items-start`;
                                    alert.innerHTML = `
                                        <i class="fas ${icons[type]} text-xl mr-3 mt-0.5"></i>
                                        <div class="flex-1">${message}</div>
                                        <button onclick="this.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    `;

                                    container.appendChild(alert);

                                    if (autoClose) {
                                        setTimeout(() => alert.remove(), 5000);
                                    }
                                }

                                // Heading Manager Functions
                                let currentEditingSection = null;
                                let headingItems = [];

                                function openHeadingManager() {
                                    const editingIndex = document.getElementById('editingIndex').value;
                                    if (editingIndex !== '') {
                                        currentEditingSection = parseInt(editingIndex);
                                        const section = sections[currentEditingSection];

                                        document.getElementById('headingManagerTitle').textContent = section.title;

                                        // Load existing headings
                                        headingItems = section.headingItems || [];
                                        renderHeadingItems();

                                        document.getElementById('headingManagerModal').style.display = 'flex';
                                    } else {
                                        showAlert('Silakan simpan section terlebih dahulu sebelum menambah heading', 'warning');
                                    }
                                }

                                function closeHeadingManager() {
                                    document.getElementById('headingManagerModal').style.display = 'none';
                                    document.getElementById('newHeadingLevel').value = 'h1';
                                    document.getElementById('newHeadingTitle').value = '';
                                }

                                function addHeadingItem() {
                                    const level = document.getElementById('newHeadingLevel').value;
                                    const title = document.getElementById('newHeadingTitle').value.trim();

                                    if (!title) {
                                        showAlert('Judul heading tidak boleh kosong', 'error');
                                        return;
                                    }

                                    headingItems.push({
                                        level: level,
                                        title: title,
                                        order: headingItems.length + 1
                                    });

                                    renderHeadingItems();

                                    // Clear form
                                    document.getElementById('newHeadingTitle').value = '';
                                    document.getElementById('newHeadingLevel').value = 'h1';

                                    showAlert('Heading berhasil ditambahkan', 'success');
                                }

                                function renderHeadingItems() {
                                    const container = document.getElementById('headingItemsList');
                                    const emptyState = document.getElementById('emptyHeadingState');
                                    const countSpan = document.getElementById('headingCount');

                                    countSpan.textContent = headingItems.length;

                                    if (headingItems.length === 0) {
                                        container.innerHTML = '';
                                        emptyState.style.display = 'block';
                                        return;
                                    }

                                    emptyState.style.display = 'none';

                                    const levelColors = {
                                        'h1': 'bg-blue-100 text-blue-800',
                                        'h2': 'bg-green-100 text-green-800',
                                        'h3': 'bg-purple-100 text-purple-800'
                                    };

                                    const levelLabels = {
                                        'h1': 'H1',
                                        'h2': 'H2',
                                        'h3': 'H3'
                                    };

                                    container.innerHTML = headingItems.map((item, index) => `
                                        <div class="bg-white border border-gray-200 rounded-lg p-3 flex items-center justify-between hover:shadow-sm transition">
                                            <div class="flex items-center space-x-3 flex-1">
                                                <div class="text-gray-400">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>
                                                <span class="px-2 py-1 rounded text-xs font-semibold ${levelColors[item.level]}">
                                                    ${levelLabels[item.level]}
                                                </span>
                                                <span class="text-sm text-gray-700 flex-1">${item.title}</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editHeadingItem(${index})" class="text-blue-600 hover:text-blue-700 text-sm px-2 py-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteHeadingItem(${index})" class="text-red-600 hover:text-red-700 text-sm px-2 py-1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    `).join('');
                                }

                                function editHeadingItem(index) {
                                    const item = headingItems[index];
                                    document.getElementById('newHeadingLevel').value = item.level;
                                    document.getElementById('newHeadingTitle').value = item.title;

                                    // Remove old item
                                    headingItems.splice(index, 1);
                                    renderHeadingItems();
                                }

                                function deleteHeadingItem(index) {
                                    if (confirm('Hapus heading ini?')) {
                                        headingItems.splice(index, 1);
                                        renderHeadingItems();
                                        showAlert('Heading berhasil dihapus', 'success');
                                    }
                                }

                                function clearAllHeadings() {
                                    if (confirm('Hapus semua heading?')) {
                                        headingItems = [];
                                        renderHeadingItems();
                                        showAlert('Semua heading berhasil dihapus', 'success');
                                    }
                                }

                                function saveHeadings() {
                                    if (currentEditingSection !== null) {
                                        sections[currentEditingSection].headingItems = [...headingItems];
                                        renderSections();
                                        closeHeadingManager();
                                        showAlert('Heading berhasil disimpan', 'success');
                            }
                        }

                        // ============================================
                        // Content Management Functions
                        // ============================================

                        let mainContentEditor = null;
                        let headingContentEditor = null;
                        let currentContentSection = null;
                        let contentHeadingItems = [];
                        let currentEditingHeadingIndex = null;                        // Initialize Quill editors when modal opens
                        function initContentEditors() {
                                    if (!mainContentEditor) {
                                        mainContentEditor = new Quill('#mainContentEditor', {
                                            theme: 'snow',
                                            placeholder: 'Tulis konten utama section di sini...',
                                            modules: {
                                                toolbar: [
                                                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                                    [{ 'font': [] }],
                                                    [{ 'size': ['small', false, 'large', 'huge'] }],
                                                    ['bold', 'italic', 'underline', 'strike'],
                                                    [{ 'color': [] }, { 'background': [] }],
                                                    [{ 'script': 'sub'}, { 'script': 'super' }],
                                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                                                    [{ 'align': [] }],
                                                    ['blockquote', 'code-block'],
                                                    ['link', 'image', 'video'],
                                                    ['clean']
                                                ]
                                            }
                                        });
                                    }

                                    if (!headingContentEditor) {
                                        headingContentEditor = new Quill('#headingContentEditor', {
                                            theme: 'snow',
                                            placeholder: 'Tulis konten heading di sini...',
                                            modules: {
                                                toolbar: [
                                                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                                    ['bold', 'italic', 'underline', 'strike'],
                                                    [{ 'color': [] }, { 'background': [] }],
                                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                                                    [{ 'align': [] }],
                                                    ['blockquote', 'code-block'],
                                                    ['link', 'image', 'video'],
                                                    ['clean']
                                                ]
                                            }
                                        });
                                    }
                                }

                                // Open Content Manager Modal
                                function manageSectionContent(index) {
                                    const section = sections[index];
                                    if (!section) return;

                                    currentContentSection = index;

                                    // Initialize editors if not already
                                    setTimeout(() => {
                                        initContentEditors();

                                        // Set title
                                        document.getElementById('contentManagerTitle').textContent = section.title;

                                        // Load main content
                                        if (section.mainContent) {
                                            mainContentEditor.root.innerHTML = section.mainContent;
                                        } else {
                                            mainContentEditor.setText('');
                                        }

                                        // Load heading items with content
                                        contentHeadingItems = section.headingItems ? JSON.parse(JSON.stringify(section.headingItems)) : [];
                                        renderContentHeadings();

                                        // Show modal
                                        document.getElementById('contentManagerModal').style.display = 'flex';

                                        // Switch to main content tab
                                        switchContentTab('main');
                                    }, 100);
                                }

                                // Close Content Manager
                                function closeContentManager() {
                                    document.getElementById('contentManagerModal').style.display = 'none';
                                    currentContentSection = null;
                                    contentHeadingItems = [];

                                    // Clear editors
                                    if (mainContentEditor) {
                                        mainContentEditor.setText('');
                                    }
                                }

                                // Switch Content Tabs
                                function switchContentTab(tab) {
                                    // Update tab buttons
                                    document.querySelectorAll('.content-tab').forEach(btn => {
                                        btn.classList.remove('border-purple-600', 'text-purple-600');
                                        btn.classList.add('border-transparent', 'text-gray-500');
                                    });

                                    if (tab === 'main') {
                                        document.getElementById('mainContentTab').classList.add('border-purple-600', 'text-purple-600');
                                        document.getElementById('mainContentTab').classList.remove('border-transparent', 'text-gray-500');
                                        document.getElementById('mainContentTabPanel').style.display = 'block';
                                        document.getElementById('headingsContentTabPanel').style.display = 'none';
                                    } else {
                                        document.getElementById('headingsContentTab').classList.add('border-purple-600', 'text-purple-600');
                                        document.getElementById('headingsContentTab').classList.remove('border-transparent', 'text-gray-500');
                                        document.getElementById('mainContentTabPanel').style.display = 'none';
                                        document.getElementById('headingsContentTabPanel').style.display = 'block';
                                    }
                                }

                                // Add Content Heading
                                function addContentHeading() {
                                    const level = document.getElementById('contentHeadingLevel').value;
                                    const title = document.getElementById('contentHeadingTitle').value.trim();

                                    if (!title) {
                                        showAlert('Judul heading tidak boleh kosong', 'error');
                                        return;
                                    }

                                    contentHeadingItems.push({
                                        level: level,
                                        title: title,
                                        content: '',
                                        order: contentHeadingItems.length + 1,
                                        id: 'heading_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
                                    });

                                    renderContentHeadings();

                                    // Clear form
                                    document.getElementById('contentHeadingTitle').value = '';
                                    document.getElementById('contentHeadingLevel').value = 'h1';

                                    showAlert('Heading berhasil ditambahkan', 'success');
                                }

                                // Render Content Headings
                                function renderContentHeadings() {
                                    const container = document.getElementById('contentHeadingsList');
                                    const emptyState = document.getElementById('emptyContentHeadingState');
                                    const countSpan = document.getElementById('contentHeadingCount');

                                    countSpan.textContent = contentHeadingItems.length;

                                    if (contentHeadingItems.length === 0) {
                                        container.innerHTML = '';
                                        emptyState.style.display = 'block';
                                        return;
                                    }

                                    emptyState.style.display = 'none';

                                    const levelColors = {
                                        'h1': 'bg-blue-100 text-blue-800 border-blue-200',
                                        'h2': 'bg-green-100 text-green-800 border-green-200',
                                        'h3': 'bg-purple-100 text-purple-800 border-purple-200'
                                    };

                                    const levelLabels = {
                                        'h1': 'H1',
                                        'h2': 'H2',
                                        'h3': 'H3'
                                    };

                                    container.innerHTML = contentHeadingItems.map((item, index) => {
                                        const contentPreview = item.content ?
                                            (item.content.replace(/<[^>]*>/g, '').substring(0, 80) + '...') :
                                            '<em class="text-gray-400">Belum ada konten</em>';

                                        return `
                <div class="bg-white border-2 ${levelColors[item.level]} rounded-lg p-3 hover:shadow-sm transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <div class="flex flex-col space-y-1 mt-1">
                                <button onclick="moveContentHeadingUp(${index})" class="text-gray-400 hover:text-blue-600 text-xs" ${index === 0 ? 'disabled' : ''}>
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <button onclick="moveContentHeadingDown(${index})" class="text-gray-400 hover:text-blue-600 text-xs" ${index === contentHeadingItems.length - 1 ? 'disabled' : ''}>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="px-2 py-1 rounded text-xs font-bold ${levelColors[item.level]}">${levelLabels[item.level]}</span>
                                    <span class="text-sm font-semibold text-gray-700">${item.title}</span>
                                </div>
                                <div class="text-xs text-gray-600 mt-1 pl-2 border-l-2 border-gray-300">${contentPreview}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <button onclick="editContentHeadingContent(${index})" class="text-purple-600 hover:text-purple-700 text-sm px-2 py-1" title="Edit Konten">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteContentHeading(${index})" class="text-red-600 hover:text-red-700 text-sm px-2 py-1" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                                    }).join('');
                                }

                                // Move Content Heading Up
                                function moveContentHeadingUp(index) {
                                    if (index > 0) {
                                        [contentHeadingItems[index], contentHeadingItems[index - 1]] =
                                        [contentHeadingItems[index - 1], contentHeadingItems[index]];
                                        renderContentHeadings();
                                    }
                                }

                                // Move Content Heading Down
                                function moveContentHeadingDown(index) {
                                    if (index < contentHeadingItems.length - 1) {
                                        [contentHeadingItems[index], contentHeadingItems[index + 1]] =
                                        [contentHeadingItems[index + 1], contentHeadingItems[index]];
                                        renderContentHeadings();
                                    }
                                }

                                // Delete Content Heading
                                function deleteContentHeading(index) {
                                    if (confirm('Hapus heading ini?')) {
                                        contentHeadingItems.splice(index, 1);
                                        renderContentHeadings();
                                        showAlert('Heading berhasil dihapus', 'success');
                                    }
                                }

                                // Clear All Content Headings
                                function clearAllContentHeadings() {
                                    if (confirm('Hapus semua heading?')) {
                                        contentHeadingItems = [];
                                        renderContentHeadings();
                                        showAlert('Semua heading berhasil dihapus', 'success');
                                    }
                                }

                                // Edit Content Heading Content
                                function editContentHeadingContent(index) {
                                    const heading = contentHeadingItems[index];
                                    if (!heading) return;

                                    currentEditingHeadingIndex = index;

                                    // Set title
                                    document.getElementById('headingEditorTitle').textContent = heading.title;

                                    // Load content to editor
                                    if (heading.content) {
                                        headingContentEditor.root.innerHTML = heading.content;
                                    } else {
                                        headingContentEditor.setText('');
                                    }

                                    // Show modal
                                    document.getElementById('headingContentEditorModal').style.display = 'flex';
                                }

                                // Close Heading Content Editor
                                function closeHeadingContentEditor() {
                                    document.getElementById('headingContentEditorModal').style.display = 'none';
                                    currentEditingHeadingIndex = null;

                                    if (headingContentEditor) {
                                        headingContentEditor.setText('');
                                    }
                                }

                                // Save Heading Content
                                function saveHeadingContent() {
                                    if (currentEditingHeadingIndex !== null) {
                                        const content = headingContentEditor.root.innerHTML;
                                        contentHeadingItems[currentEditingHeadingIndex].content = content;

                                        renderContentHeadings();
                                        closeHeadingContentEditor();
                                        showAlert('Konten heading berhasil disimpan', 'success');
                                    }
                                }

                                // Save Content Manager (Main Content + All Headings)
                                function saveContentManager() {
                                    if (currentContentSection !== null) {
                                        // Save main content
                                        sections[currentContentSection].mainContent = mainContentEditor.root.innerHTML;

                                        // Save heading items with content
                                        sections[currentContentSection].headingItems = JSON.parse(JSON.stringify(contentHeadingItems));

                                        renderSections();
                                        closeContentManager();
                                        showAlert('Konten section berhasil disimpan', 'success');
                                    }
                                }

                                // Initialize sortable for sections (drag and drop)
                                document.addEventListener('DOMContentLoaded', function() {
                                    const sectionsContainer = document.getElementById('sectionsContainer');
                                    if (sectionsContainer) {
                                        new Sortable(sectionsContainer, {
                                            animation: 150,
                                            ghostClass: 'bg-blue-100',
                                            handle: '.cursor-move',
                                            onEnd: function(evt) {
                                                const oldIndex = evt.oldIndex;
                                                const newIndex = evt.newIndex;

                                                if (oldIndex !== newIndex) {
                                                    const movedSection = sections.splice(oldIndex, 1)[0];
                                                    sections.splice(newIndex, 0, movedSection);
                                                    sections.forEach((section, index) => {
                                                        section.order = index + 1;
                                                    });
                                                    renderSections();
                                                    showAlert('Urutan section berhasil diubah', 'success');
                                                }
                                            }
                                        });
                                    }
                                });
        </script>
    @endpush
</x-app-layout>

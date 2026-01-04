{{-- Add/Edit Section Form --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 py-3 rounded-t-lg">
        <h3 class="text-sm font-bold text-white flex items-center">
            <i class="fas fa-plus-circle mr-2"></i><span id="formTitle">Tambah Bagian</span>
        </h3>
    </div>
    <div class="p-4 space-y-3">
        <input type="hidden" id="editingIndex" value="-1">

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Bagian *</label>
            <input type="text" id="sectionTitle" placeholder="Contoh: BAB I PENDAHULUAN"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea id="sectionDescription" rows="2" placeholder="Jelaskan bagian ini..."
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition"></textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="sectionRequired"
                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
            <label for="sectionRequired" class="ml-2 text-xs font-medium text-gray-700">Wajib diisi</label>
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
                        <label class="block text-xs text-gray-600 mb-1">Ukuran Font</label>
                        <select id="headingFontSize"
                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-green-500">
                            <option value="12">12pt</option>
                            <option value="14" selected>14pt</option>
                            <option value="16">16pt</option>
                            <option value="18">18pt</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Alignment</label>
                        <select id="headingAlignment"
                            class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-green-500">
                            <option value="left">Kiri</option>
                            <option value="center" selected>Tengah</option>
                            <option value="right">Kanan</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mt-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="headingBold" checked
                            class="w-3 h-3 text-green-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Bold</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="headingUppercase"
                            class="w-3 h-3 text-green-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">UPPERCASE</span>
                    </label>
                </div>
            </div>

            <!-- Subheading Settings -->
            <div class="bg-gray-50 rounded-lg p-3 mb-2">
                <p class="text-xs font-semibold text-gray-700 mb-2">
                    <i class="fas fa-layer-group mr-1"></i>Sub-Judul
                </p>

                @foreach (['H1' => 'Heading 1', 'H2' => 'Heading 2', 'H3' => 'Heading 3'] as $level => $label)
                    <div class="mb-2">
                        <label class="flex items-center space-x-2 mb-2">
                            <input type="checkbox" id="enable{{ $level }}"
                                class="w-3 h-3 text-indigo-600 border-gray-300 rounded"
                                onchange="toggleSubheadingSettings('{{ strtolower($level) }}')">
                            <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                        </label>
                        <div id="{{ strtolower($level) }}Settings" class="ml-5 hidden">
                            <div class="grid grid-cols-3 gap-2">
                                <select id="{{ strtolower($level) }}FontSize"
                                    class="px-2 py-1 text-xs border border-gray-300 rounded">
                                    <option value="12" selected>12pt</option>
                                    <option value="14">14pt</option>
                                    <option value="16">16pt</option>
                                </select>
                                <select id="{{ strtolower($level) }}Style"
                                    class="px-2 py-1 text-xs border border-gray-300 rounded">
                                    <option value="normal">Normal</option>
                                    <option value="bold" selected>Bold</option>
                                    <option value="italic">Italic</option>
                                </select>
                                <select id="{{ strtolower($level) }}Align"
                                    class="px-2 py-1 text-xs border border-gray-300 rounded">
                                    <option value="left" selected>Kiri</option>
                                    <option value="center">Tengah</option>
                                    <option value="right">Kanan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Content Settings -->
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-xs font-semibold text-gray-700 mb-2">
                    <i class="fas fa-cog mr-1"></i>Pengaturan Konten
                </p>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="hasNumbering" class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Penomoran otomatis</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="hasIndentation" checked
                            class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Indentasi paragraf</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="allowImages" class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Izinkan gambar</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="allowTables"
                            class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Izinkan tabel</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="pageBreakBefore"
                            class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-700">Page break sebelum section</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-2 pt-3 border-t">
            <button type="button" id="saveSectionBtn"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-check mr-1"></i><span id="saveSectionBtnText">Tambahkan</span>
            </button>
            <button type="button" id="cancelEditBtn"
                class="hidden bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-times mr-1"></i>Batal
            </button>
        </div>
    </div>
</div>

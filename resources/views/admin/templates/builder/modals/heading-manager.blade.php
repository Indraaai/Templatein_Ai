{{-- Heading Manager Modal --}}
<div id="headingManagerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
    style="display: none;">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-list-alt mr-2"></i>
                    <span>Kelola Heading - <span id="headingManagerTitle">Section</span></span>
                </h3>
                <button type="button" onclick="window.builderController.closeHeadingManager()"
                    class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 180px);">

            <!-- Add Heading Buttons -->
            <div class="flex space-x-2 mb-4">
                <button type="button" onclick="window.builderController.addNewHeading('h1')"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i>Add H1 (1.1, 1.2)
                </button>
                <button type="button" onclick="window.builderController.addNewHeading('h2')"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i>Add H2 (1.1.1)
                </button>
                <button type="button" onclick="window.builderController.addNewHeading('h3')"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i>Add H3
                </button>
            </div>

            <!-- Stats -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <div class="flex space-x-4 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-heading text-blue-600 mr-2"></i>
                        <span class="text-gray-700">H1: <span id="h1Count" class="font-bold">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-heading text-green-600 mr-2"></i>
                        <span class="text-gray-700">H2: <span id="h2Count" class="font-bold">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-heading text-purple-600 mr-2"></i>
                        <span class="text-gray-700">H3: <span id="h3Count" class="font-bold">0</span></span>
                    </div>
                    <div class="flex items-center ml-auto">
                        <i class="fas fa-list text-gray-600 mr-2"></i>
                        <span class="text-gray-700">Total: <span id="totalHeadingCount"
                                class="font-bold">0</span></span>
                    </div>
                </div>
            </div>

            <!-- Heading Items List -->
            <div class="space-y-2" id="headingItemsList">
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p class="text-sm">Belum ada heading yang ditambahkan</p>
                    <p class="text-xs mt-1">Klik tombol di atas untuk menambah heading</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t px-6 py-4 bg-gray-50 flex justify-between">
            <button type="button" onclick="window.builderController.clearAllHeadings()"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                <i class="fas fa-trash mr-1"></i>Hapus Semua
            </button>
            <div class="flex space-x-2">
                <button type="button" onclick="window.builderController.closeHeadingManager()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-times mr-1"></i>Tutup
                </button>
                <button type="button" onclick="window.builderController.saveHeadings()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-check mr-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Heading Input Modal (for add/edit) --}}
<div id="headingInputModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60]"
    style="display: none;">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-lg">
            <h4 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-edit mr-2"></i>
                <span id="headingInputModalTitle">Tambah Heading</span>
            </h4>
        </div>
        <div class="p-6">
            <input type="hidden" id="headingInputIndex" value="-1">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Level</label>
                <select id="headingInputLevel"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="h1">H1 (1.1, 1.2, dst)</option>
                    <option value="h2">H2 (1.1.1, 1.2.1, dst)</option>
                    <option value="h3">H3 (Sub-sub heading)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Heading *</label>
                <input type="text" id="headingInputNumber" placeholder="Contoh: 1.1 atau 1.1.1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Format: 1.1, 1.2 untuk H1 | 1.1.1, 1.2.1 untuk H2</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Heading *</label>
                <input type="text" id="headingInputTitle" placeholder="Contoh: Latar Belakang"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten (Opsional)</label>
                <textarea id="headingInputContent" rows="3" placeholder="Konten untuk heading ini..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">Atau klik "Edit Content" nanti untuk rich text editor</p>
            </div>
        </div>
        <div class="border-t px-6 py-4 bg-gray-50 flex justify-end space-x-2">
            <button type="button" onclick="window.builderController.closeHeadingInput()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                Batal
            </button>
            <button type="button" onclick="window.builderController.saveHeadingInput()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                Simpan
            </button>
        </div>
    </div>
</div>

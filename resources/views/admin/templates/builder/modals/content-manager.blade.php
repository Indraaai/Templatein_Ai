{{-- Content Manager Modal --}}
<div id="contentManagerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
    style="display: none;">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    <span>Kelola Konten - <span id="contentManagerTitle">Section</span></span>
                </h3>
                <button type="button" onclick="window.builderController.closeContentManager()"
                    class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 180px);">

            <!-- Tabs -->
            <div class="flex border-b mb-4">
                <button type="button" id="mainContentTab" onclick="window.builderController.switchContentTab('main')"
                    class="px-4 py-2 font-medium text-sm border-b-2 border-purple-600 text-purple-600">
                    <i class="fas fa-file-text mr-1"></i>Konten Utama
                </button>
                <button type="button" id="headingContentTab"
                    onclick="window.builderController.switchContentTab('heading')"
                    class="px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-600 hover:text-gray-800">
                    <i class="fas fa-list mr-1"></i>Konten Heading (<span id="headingContentCount">0</span>)
                </button>
            </div>

            <!-- Main Content Tab -->
            <div id="mainContentTabContent" class="content-tab-pane">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-paragraph mr-1"></i>Konten Utama Section
                    </label>
                    <p class="text-xs text-gray-600 mb-3">
                        Konten ini akan muncul setelah judul section dan sebelum heading items (jika ada).
                    </p>

                    <!-- Quill Editor Container -->
                    <div id="mainContentEditor" class="bg-white border border-gray-300 rounded-lg quill-editor-large">
                    </div>

                    <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                        <span><span id="mainContentWordCount">0</span> kata</span>
                        <span>
                            <i class="fas fa-info-circle mr-1"></i>
                            Gunakan toolbar untuk formatting teks, tambah gambar, tabel, dll
                        </span>
                    </div>
                </div>
            </div>

            <!-- Heading Content Tab -->
            <div id="headingContentTabContent" class="content-tab-pane hidden">
                <div class="mb-4">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Tentang Konten Heading</p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Di sini Anda bisa mengedit konten detail untuk setiap heading (H1, H2, H3) yang
                                    sudah ditambahkan via "Kelola Heading".
                                    Jika belum ada heading, silakan klik "Kelola Heading" terlebih dahulu.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="headingContentList" class="space-y-3">
                        <!-- Heading content items will be rendered here -->
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p class="text-sm">Belum ada heading yang ditambahkan</p>
                            <button type="button"
                                onclick="window.builderController.closeContentManager(); window.builderController.openHeadingManager();"
                                class="mt-3 text-purple-600 hover:text-purple-700 text-sm font-medium">
                                <i class="fas fa-arrow-right mr-1"></i>Kelola Heading
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t px-6 py-4 bg-gray-50 flex justify-between">
            <div class="text-xs text-gray-600">
                <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                <span>Tip: Gunakan Ctrl+B untuk bold, Ctrl+I untuk italic</span>
            </div>
            <div class="flex space-x-2">
                <button type="button" onclick="window.builderController.closeContentManager()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-times mr-1"></i>Tutup
                </button>
                <button type="button" onclick="window.builderController.saveContent()"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-check mr-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Heading Content Editor Modal (for editing individual heading content) --}}
<div id="headingContentEditorModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60]" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    <span id="headingContentEditorTitle">Edit Konten Heading</span>
                </h4>
                <button type="button" onclick="window.builderController.closeHeadingContentEditor()"
                    class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 180px);">
            <input type="hidden" id="editingHeadingContentIndex" value="-1">

            <!-- Quill Editor for Heading Content -->
            <div id="headingContentEditor" class="bg-white border border-gray-300 rounded-lg quill-editor-large"></div>

            <div class="mt-2 text-xs text-gray-500">
                <span><span id="headingContentWordCount">0</span> kata</span>
            </div>
        </div>
        <div class="border-t px-6 py-4 bg-gray-50 flex justify-end space-x-2">
            <button type="button" onclick="window.builderController.closeHeadingContentEditor()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                Batal
            </button>
            <button type="button" onclick="window.builderController.saveHeadingContentEditor()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                Simpan
            </button>
        </div>
    </div>
</div>

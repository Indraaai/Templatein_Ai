{{-- Sections List Display --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3 rounded-t-lg">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-white flex items-center">
                <i class="fas fa-list mr-2"></i>Daftar Bagian (<span id="sectionCount">0 Bagian</span>)
            </h3>
            <div class="flex space-x-2">
                <button type="button" id="loadSkripsiBtn"
                    class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition duration-200">
                    <i class="fas fa-file-alt mr-1"></i>Template Skripsi
                </button>
                <button type="button" id="loadProposalBtn"
                    class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition duration-200">
                    <i class="fas fa-file mr-1"></i>Template Proposal
                </button>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div id="sectionsContainer" class="space-y-2">
            <!-- Sections will be rendered here dynamically -->
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p class="text-sm">Belum ada bagian yang ditambahkan</p>
                <p class="text-xs mt-1">Gunakan form di sebelah kiri atau template cepat</p>
            </div>
        </div>
    </div>
</div>

{{-- Document Formatting Panel --}}
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
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <option value="Times New Roman">Times New Roman</option>
                <option value="Arial">Arial</option>
                <option value="Calibri">Calibri</option>
                <option value="Georgia">Georgia</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Ukuran (pt)</label>
                <input type="number" id="fontSize" min="8" max="72" value="12"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Spasi</label>
                <select id="lineSpacing"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    <option value="1">1.0</option>
                    <option value="1.15">1.15</option>
                    <option value="1.5" selected>1.5</option>
                    <option value="2">2.0</option>
                </select>
            </div>
        </div>

        <!-- Page Settings -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Kertas</label>
                <select id="pageSize"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    <option value="A4" selected>A4</option>
                    <option value="Letter">Letter</option>
                    <option value="Legal">Legal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Orientasi</label>
                <select id="orientation"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    <option value="portrait" selected>Portrait</option>
                    <option value="landscape">Landscape</option>
                </select>
            </div>
        </div>

        <!-- Margins -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-2">Margin (cm)</label>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <input type="number" id="marginTop" placeholder="Atas" min="0" step="0.5" value="3"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 transition">
                </div>
                <div>
                    <input type="number" id="marginBottom" placeholder="Bawah" min="0" step="0.5"
                        value="3"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 transition">
                </div>
                <div>
                    <input type="number" id="marginLeft" placeholder="Kiri" min="0" step="0.5"
                        value="4"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 transition">
                </div>
                <div>
                    <input type="number" id="marginRight" placeholder="Kanan" min="0" step="0.5"
                        value="3"
                        class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>
        </div>
    </div>
</div>

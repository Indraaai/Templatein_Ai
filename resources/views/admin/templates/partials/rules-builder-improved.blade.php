{{-- Improved Rules Builder Component - Responsive & Modern UI --}}
<div x-data="rulesBuilder()" x-init="init()" class="space-y-4">

    {{-- Formatting Settings (Collapsible) --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div x-data="{ settingsOpen: false }">
            {{-- Header --}}
            <button type="button" @click="settingsOpen = !settingsOpen"
                class="w-full px-4 sm:px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Pengaturan
                                Format Dokumen</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Atur ukuran halaman,
                                margin, dan font</p>
                        </div>
                    </div>
                    <svg class="h-5 w-5 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        :class="{ 'rotate-180': settingsOpen }" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </button>

            {{-- Collapsible Content --}}
            <div x-show="settingsOpen" x-collapse class="border-t border-gray-100 dark:border-gray-700">
                <div class="p-4 sm:p-6 space-y-5">
                    {{-- Basic Settings --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📏 Ukuran Halaman
                            </label>
                            <select x-model="formatting.page_size"
                                class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="A4">A4 (21 × 29.7 cm)</option>
                                <option value="Letter">Letter (21.6 × 27.9 cm)</option>
                                <option value="Legal">Legal (21.6 × 35.6 cm)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🔄 Orientasi
                            </label>
                            <select x-model="formatting.orientation"
                                class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="portrait">Portrait (Vertikal)</option>
                                <option value="landscape">Landscape (Horizontal)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🔤 Jenis Font
                            </label>
                            <select x-model="formatting.font.name"
                                class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Arial">Arial</option>
                                <option value="Calibri">Calibri</option>
                                <option value="Cambria">Cambria</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📐 Ukuran Font (pt)
                            </label>
                            <input type="number" x-model.number="formatting.font.size" min="8" max="72"
                                class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📊 Jarak Baris
                            </label>
                            <select x-model.number="formatting.font.line_spacing"
                                class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option :value="1">Single (1.0)</option>
                                <option :value="1.15">1.15</option>
                                <option :value="1.5">1.5</option>
                                <option :value="2">Double (2.0)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Margins --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            📐 Margin Halaman (cm)
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 block">⬆️ Atas</label>
                                <input type="number" x-model.number="formatting.margin.top" min="0"
                                    max="10" step="0.5" placeholder="3.0"
                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 block">⬇️ Bawah</label>
                                <input type="number" x-model.number="formatting.margin.bottom" min="0"
                                    max="10" step="0.5" placeholder="3.0"
                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 block">⬅️ Kiri</label>
                                <input type="number" x-model.number="formatting.margin.left" min="0"
                                    max="10" step="0.5" placeholder="4.0"
                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400 mb-1.5 block">➡️ Kanan</label>
                                <input type="number" x-model.number="formatting.margin.right" min="0"
                                    max="10" step="0.5" placeholder="3.0"
                                    class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Document Structure Builder --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{-- Header --}}
        <div
            class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-800/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Struktur Dokumen
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            <span x-text="sections.length"></span> section ·
                            <span x-text="sections.reduce((sum, s) => sum + s.elements.length, 0)"></span> elements
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="loadSampleRules()"
                        class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-4 w-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">Load Sample</span>
                    </button>
                    <button type="button" @click="addSection('chapter')"
                        class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-5 w-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Add Section</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Sections List --}}
        <div class="p-4 sm:p-6">
            <div class="space-y-4">
                <template x-for="(section, sectionIndex) in sections" :key="sectionIndex">
                    <div
                        class="border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all bg-white dark:bg-gray-800">
                        {{-- Section Header --}}
                        <div
                            class="bg-gradient-to-r from-indigo-50 via-blue-50 to-indigo-50 dark:from-gray-700 dark:via-gray-750 dark:to-gray-700 px-3 sm:px-4 py-3">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                    <select x-model="section.type"
                                        class="text-xs sm:text-sm font-medium rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-shrink-0">
                                        <option value="cover">📑 Cover</option>
                                        <option value="chapter">📖 Chapter</option>
                                    </select>

                                    <template x-if="section.type === 'chapter'">
                                        <div class="flex items-center gap-1.5">
                                            <span
                                                class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">BAB</span>
                                            <input type="number" x-model.number="section.chapter_number"
                                                class="w-12 sm:w-16 text-sm font-bold text-center rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </template>

                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                        </svg>
                                        <span x-text="section.elements.length"></span>
                                    </span>
                                </div>

                                <div class="flex items-center gap-1 justify-end sm:justify-start">
                                    <button type="button" @click="moveSection(sectionIndex, sectionIndex - 1)"
                                        x-show="sectionIndex > 0"
                                        class="p-2 text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-white/80 dark:hover:bg-gray-600/80 rounded-lg transition-all"
                                        title="Move Up">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="moveSection(sectionIndex, sectionIndex + 1)"
                                        x-show="sectionIndex < sections.length - 1"
                                        class="p-2 text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-white/80 dark:hover:bg-gray-600/80 rounded-lg transition-all"
                                        title="Move Down">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="removeSection(sectionIndex)"
                                        class="p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all"
                                        title="Delete Section">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Elements List --}}
                        <div class="p-3 sm:p-4 space-y-2 bg-gray-50/50 dark:bg-gray-800/50">
                            <template x-for="(element, elementIndex) in section.elements" :key="elementIndex">
                                <div
                                    class="group relative flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 bg-white dark:bg-gray-700/80 p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md transition-all">
                                    <div class="flex items-center gap-2 flex-1 min-w-0 w-full sm:w-auto">
                                        <span class="text-lg flex-shrink-0"
                                            x-text="getElementIcon(element.type)"></span>

                                        <select x-model="element.type"
                                            class="text-xs sm:text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-28 sm:w-auto">
                                            <option value="heading">Heading</option>
                                            <option value="paragraph">Paragraph</option>
                                            <option value="list">List</option>
                                            <option value="table">Table</option>
                                            <option value="image">Image</option>
                                            <option value="page_break">Break</option>
                                            <option value="text_break">Space</option>
                                            <option value="line">Line</option>
                                        </select>

                                        <span
                                            class="flex-1 text-xs sm:text-sm text-gray-700 dark:text-gray-300 truncate font-medium"
                                            x-text="getElementLabel(element)"></span>
                                    </div>

                                    <div
                                        class="flex items-center gap-1 w-full sm:w-auto justify-end sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        <button type="button"
                                            @click="moveElement(sectionIndex, elementIndex, elementIndex - 1)"
                                            x-show="elementIndex > 0"
                                            class="p-1.5 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all"
                                            title="Move Up">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            @click="moveElement(sectionIndex, elementIndex, elementIndex + 1)"
                                            x-show="elementIndex < section.elements.length - 1"
                                            class="p-1.5 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all"
                                            title="Move Down">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <button type="button" @click="openEditModal(sectionIndex, elementIndex)"
                                            class="px-2.5 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-all shadow-sm hover:shadow">
                                            <span class="hidden sm:inline">Edit</span>
                                            <svg class="h-4 w-4 sm:hidden" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" @click="removeElement(sectionIndex, elementIndex)"
                                            class="p-1.5 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all"
                                            title="Delete">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            {{-- Add Element Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-all">
                                    <svg class="h-5 w-5 inline-block mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add New Element
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    class="absolute z-20 mt-2 w-full bg-white dark:bg-gray-700 shadow-xl rounded-xl border border-gray-200 dark:border-gray-600 py-1 max-h-80 overflow-y-auto"
                                    style="display: none;" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95">

                                    <div
                                        class="px-3 py-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pilih Jenis
                                            Element</p>
                                    </div>

                                    <button type="button" @click="addElement(sectionIndex, 'heading'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">📝</span>
                                            <div>
                                                <div class="font-semibold">Heading</div>
                                                <div class="text-xs text-gray-500">Judul atau subjudul</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button"
                                        @click="addElement(sectionIndex, 'paragraph'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">📄</span>
                                            <div>
                                                <div class="font-semibold">Paragraph</div>
                                                <div class="text-xs text-gray-500">Teks paragraf biasa</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" @click="addElement(sectionIndex, 'list'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">•</span>
                                            <div>
                                                <div class="font-semibold">List</div>
                                                <div class="text-xs text-gray-500">Daftar item (bullet/number)</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" @click="addElement(sectionIndex, 'table'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">⊞</span>
                                            <div>
                                                <div class="font-semibold">Table</div>
                                                <div class="text-xs text-gray-500">Tabel data</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" @click="addElement(sectionIndex, 'image'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">🖼️</span>
                                            <div>
                                                <div class="font-semibold">Image</div>
                                                <div class="text-xs text-gray-500">Gambar atau ilustrasi</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button"
                                        @click="addElement(sectionIndex, 'page_break'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">---</span>
                                            <div>
                                                <div class="font-semibold">Page Break</div>
                                                <div class="text-xs text-gray-500">Pindah halaman baru</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button"
                                        @click="addElement(sectionIndex, 'text_break'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">↵</span>
                                            <div>
                                                <div class="font-semibold">Text Break</div>
                                                <div class="text-xs text-gray-500">Baris kosong (spasi)</div>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" @click="addElement(sectionIndex, 'line'); open = false"
                                        class="w-full px-4 py-2.5 text-left text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-700 dark:text-gray-300 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">━</span>
                                            <div>
                                                <div class="font-semibold">Horizontal Line</div>
                                                <div class="text-xs text-gray-500">Garis pembatas</div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Empty State --}}
                <div x-show="sections.length === 0"
                    class="text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50/50 dark:bg-gray-800/50">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">Belum ada section</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                        Klik tombol <strong>"Add Section"</strong> untuk menambahkan bagian dokumen,<br>
                        atau <strong>"Load Sample"</strong> untuk melihat contoh
                    </p>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <button type="button" @click="loadSampleRules()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Load Sample
                        </button>
                        <button type="button" @click="addSection('chapter')"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Section
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden JSON Textarea (for form submission) --}}
    <textarea name="template_rules" id="template_rules" class="hidden" required></textarea>

    {{-- Edit Modal --}}
    @include('admin.templates.partials.edit-modal')
</div>

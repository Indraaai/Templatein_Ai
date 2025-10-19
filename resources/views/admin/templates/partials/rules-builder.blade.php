{{-- Rules Builder Component --}}
<div x-data="rulesBuilder()" x-init="init()" class="space-y-4">

    {{-- Formatting Settings --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        {{-- Collapsible Header --}}
        <div class="px-4 sm:px-6 py-4 cursor-pointer" x-data="{ open: false }" @click="open = !open">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Format
                            Dokumen</h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Atur ukuran halaman,
                            margin, dan font</p>
                    </div>
                </div>
                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

        {{-- Collapsible Content --}}
        <div x-show="open" x-collapse class="px-4 sm:px-6 pb-4 sm:pb-6 border-t border-gray-100 dark:border-gray-700">
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                {{-- Page Size --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        📏 Ukuran Halaman
                    </label>
                    <select x-model="formatting.page_size"
                        class="w-full text-sm sm:text-base rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        <option value="A4">A4 (21 × 29.7 cm)</option>
                        <option value="Letter">Letter (21.6 × 27.9 cm)</option>
                        <option value="Legal">Legal (21.6 × 35.6 cm)</option>
                    </select>
                </div>

                {{-- Orientation --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        🔄 Orientasi
                    </label>
                    <select x-model="formatting.orientation"
                        class="w-full text-sm sm:text-base rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        <option value="portrait">Portrait (Vertikal)</option>
                        <option value="landscape">Landscape (Horizontal)</option>
                    </select>
                </div>

                {{-- Font Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        🔤 Jenis Font
                    </label>
                    <select x-model="formatting.font.name"
                        class="w-full text-sm sm:text-base rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Arial">Arial</option>
                        <option value="Calibri">Calibri</option>
                        <option value="Cambria">Cambria</option>
                    </select>
                </div>

                {{-- Font Size --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        📐 Ukuran Font (pt)
                    </label>
                    <input type="number" x-model.number="formatting.font.size" min="8" max="72"
                        class="w-full text-sm sm:text-base rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                </div>

                {{-- Line Spacing --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        📊 Jarak Baris
                    </label>
                    <select x-model.number="formatting.font.line_spacing"
                        class="w-full text-sm sm:text-base rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        <option :value="1">Single (1.0)</option>
                        <option :value="1.15">1.15</option>
                        <option :value="1.5">1.5</option>
                        <option :value="2">Double (2.0)</option>
                    </select>
                </div>
            </div>

            {{-- Margins --}}
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    📐 Margin Halaman (cm)
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">⬆️ Atas</label>
                        <input type="number" x-model.number="formatting.margin.top" min="0" max="10"
                            step="0.5" placeholder="3.0"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">⬇️ Bawah</label>
                        <input type="number" x-model.number="formatting.margin.bottom" min="0" max="10"
                            step="0.5" placeholder="3.0"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">⬅️ Kiri</label>
                        <input type="number" x-model.number="formatting.margin.left" min="0" max="10"
                            step="0.5" placeholder="4.0"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">➡️ Kanan</label>
                        <input type="number" x-model.number="formatting.margin.right" min="0" max="10"
                            step="0.5" placeholder="3.0"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Document Structure Builder --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Struktur Dokumen
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            <span x-text="sections.length"></span> section,
                            <span x-text="sections.reduce((sum, s) => sum + s.elements.length, 0)"></span> elements
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="button" @click="loadSampleRules()"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">Load Sample</span>
                        <span class="sm:hidden">Sample</span>
                    </button>
                    <button type="button" @click="addSection('chapter')"
                        class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Add Section</span>
                        <span class="sm:hidden">Add</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Sections List --}}
        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
            <template x-for="(section, sectionIndex) in sections" :key="sectionIndex">
                <div
                    class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden bg-gradient-to-r from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 shadow-sm hover:shadow-md transition-shadow">
                    {{-- Section Header --}}
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-gray-700 dark:to-gray-750 px-3 sm:px-4 py-2.5 sm:py-3">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                            <div class="flex items-center space-x-2 sm:space-x-3 flex-1 min-w-0">
                                <select x-model="section.type"
                                    class="text-xs sm:text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-shrink-0">
                                    <option value="cover">📑 Cover</option>
                                    <option value="chapter">📖 Chapter</option>
                                </select>

                                <template x-if="section.type === 'chapter'">
                                    <div class="flex items-center space-x-1.5 flex-shrink-0">
                                        <span
                                            class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">BAB</span>
                                        <input type="number" x-model.number="section.chapter_number"
                                            class="w-12 sm:w-16 text-xs sm:text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </template>

                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 flex-shrink-0">
                                    <span x-text="section.elements.length"></span>
                                    <span class="ml-1 hidden sm:inline"
                                        x-text="section.elements.length !== 1 ? 'elements' : 'element'"></span>
                                    <span class="ml-1 sm:hidden">el</span>
                                </span>
                            </div>

                            <div class="flex items-center space-x-1 justify-end">
                                <button type="button" @click="moveSection(sectionIndex, sectionIndex - 1)"
                                    x-show="sectionIndex > 0"
                                    class="p-1.5 sm:p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-white dark:hover:bg-gray-600 rounded-lg transition-all"
                                    title="Move Up">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                                <button type="button" @click="moveSection(sectionIndex, sectionIndex + 1)"
                                    x-show="sectionIndex < sections.length - 1"
                                    class="p-1.5 sm:p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-white dark:hover:bg-gray-600 rounded-lg transition-all"
                                    title="Move Down">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <button type="button" @click="removeSection(sectionIndex)"
                                    class="p-1.5 sm:p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all"
                                    title="Delete Section">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Elements List --}}
                    <div class="p-3 sm:p-4 space-y-2.5">
                        <template x-for="(element, elementIndex) in section.elements" :key="elementIndex">
                            <div
                                class="bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 sm:p-4 group hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-md transition-all">
                                {{-- Element Header --}}
                                <div class="flex items-start space-x-3">
                                    {{-- Icon --}}
                                    <div class="flex-shrink-0 mt-0.5">
                                        <span class="text-2xl" x-text="getElementIcon(element.type)"></span>
                                    </div>

                                    {{-- Content Area --}}
                                    <div class="flex-1 min-w-0 space-y-2">
                                        {{-- Type Selector --}}
                                        <div class="flex items-center space-x-2">
                                            <select x-model="element.type"
                                                class="flex-1 text-sm font-medium rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="heading">📝 Heading</option>
                                                <option value="paragraph">📄 Paragraph</option>
                                                <option value="list">• List</option>
                                                <option value="table">⊞ Table</option>
                                                <option value="image">🖼️ Image</option>
                                                <option value="page_break">--- Page Break</option>
                                                <option value="text_break">↵ Text Break</option>
                                                <option value="line">━ Line</option>
                                            </select>

                                            {{-- Element Number Badge --}}
                                            <span
                                                class="flex-shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-600 text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                #<span x-text="elementIndex + 1"></span>
                                            </span>
                                        </div>

                                        {{-- Preview Text --}}
                                        <div
                                            class="bg-gray-50 dark:bg-gray-800 rounded-md px-3 py-2 border border-gray-200 dark:border-gray-600">
                                            <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2"
                                                x-text="getElementLabel(element) || 'No content yet...'"></p>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex-shrink-0 flex flex-col space-y-1">
                                        <button type="button"
                                            @click="moveElement(sectionIndex, elementIndex, elementIndex - 1)"
                                            x-show="elementIndex > 0"
                                            class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded transition-all"
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
                                            class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded transition-all"
                                            title="Move Down">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Action Bar (visible on hover) --}}
                                <div
                                    class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-600 flex items-center justify-between opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" @click="openEditModal(sectionIndex, elementIndex)"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                                        <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Details
                                    </button>
                                    <button type="button" @click="removeElement(sectionIndex, elementIndex)"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                                        <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </template>

                        {{-- Add Element Dropdown --}}
                        <div class="relative mt-3" x-data="{ open: false }">
                            <button type="button" @click="open = !open"
                                class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 border-2 border-dashed border-indigo-300 dark:border-indigo-600 rounded-lg transition-all">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Element
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-20 mt-2 w-full bg-white dark:bg-gray-700 shadow-xl rounded-lg border border-gray-200 dark:border-gray-600 py-2 max-h-96 overflow-y-auto"
                                style="display: none;">
                                <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                    <p
                                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Choose Element Type</p>
                                </div>
                                <button type="button" @click="addElement(sectionIndex, 'heading'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">📝</span>
                                    <div>
                                        <div class="font-semibold">Heading</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Add a title or section
                                            header</div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'paragraph'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">📄</span>
                                    <div>
                                        <div class="font-semibold">Paragraph</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Add regular text content
                                        </div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'list'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">📋</span>
                                    <div>
                                        <div class="font-semibold">List</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Bullet or numbered list
                                        </div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'table'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">⊞</span>
                                    <div>
                                        <div class="font-semibold">Table</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Structured data table
                                        </div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'image'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">🖼️</span>
                                    <div>
                                        <div class="font-semibold">Image</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Insert picture or logo
                                        </div>
                                    </div>
                                </button>
                                <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                <button type="button" @click="addElement(sectionIndex, 'page_break'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">📄</span>
                                    <div>
                                        <div class="font-semibold">Page Break</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Start new page</div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'text_break'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">↵</span>
                                    <div>
                                        <div class="font-semibold">Text Break</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Add blank lines</div>
                                    </div>
                                </button>
                                <button type="button" @click="addElement(sectionIndex, 'line'); open = false"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center space-x-3">
                                    <span class="text-xl">━</span>
                                    <div>
                                        <div class="font-semibold">Horizontal Line</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Visual separator</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Empty State --}}
            <div x-show="sections.length === 0"
                class="text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Belum ada section</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 px-4">
                        Mulai membuat struktur dokumen dengan menambahkan section pertama atau gunakan contoh template
                    </p>
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <button type="button" @click="addSection('chapter')"
                            class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add First Section
                        </button>
                        <button type="button" @click="loadSampleRules()"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Load Sample Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden JSON Textarea (for form submission) --}}
    <textarea name="template_rules" id="template_rules" class="hidden" required></textarea>

    {{-- Edit Modal (will be created separately) --}}
    @include('admin.templates.partials.edit-modal')
</div>

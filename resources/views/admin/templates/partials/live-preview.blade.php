{{-- Live Preview Component - Shares data with rulesBuilder --}}
<div class="sticky top-4">
    {{-- Preview Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-t-lg border border-gray-200 dark:border-gray-700 px-4 py-3">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center text-sm sm:text-base">
                <svg class="h-5 w-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span class="hidden sm:inline">Live Preview</span>
                <span class="sm:hidden">Preview</span>
                <span
                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    <span class="w-1.5 h-1.5 mr-1 bg-green-400 rounded-full animate-pulse"></span>
                    Live
                </span>
            </h3>

            {{-- Zoom Controls --}}
            <div class="flex items-center space-x-1 sm:space-x-2">
                <button type="button" @click="zoom = Math.max(50, zoom - 25)"
                    class="p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition"
                    title="Zoom Out">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                    </svg>
                </button>
                <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 min-w-[3rem] text-center"
                    x-text="zoom + '%'"></span>
                <button type="button" @click="zoom = Math.min(150, zoom + 25)"
                    class="p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition"
                    title="Zoom In">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Preview Content --}}
    <div class="bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 border-x border-b border-gray-200 dark:border-gray-700 rounded-b-lg p-3 sm:p-4 overflow-auto"
        style="max-height: calc(100vh - 200px);">

        {{-- Document Page Shadow Container --}}
        <div class="transition-all duration-200"
            :style="`transform: scale(${zoom / 100}); transform-origin: top center;`">
            <div class="bg-white shadow-2xl mx-auto rounded-sm overflow-hidden"
                :style="`width: ${getPageWidth()}px; min-height: ${getPageHeight()}px;`">

                {{-- Document Content --}}
                <div class="document-content"
                    :style="`
                                                            padding-top: ${formatting.margin.top * 37.8}px;
                                                            padding-bottom: ${formatting.margin.bottom * 37.8}px;
                                                            padding-left: ${formatting.margin.left * 37.8}px;
                                                            padding-right: ${formatting.margin.right * 37.8}px;
                                                            font-family: '${formatting.font.name}', serif;
                                                            font-size: ${formatting.font.size}pt;
                                                            line-height: ${formatting.font.line_spacing};
                                                            color: #000;
                                                        `">

                    {{-- Render Sections --}}
                    <template x-for="(section, sIndex) in sections" :key="sIndex">
                        <div class="section" :class="section.type === 'chapter' ? 'chapter-section' : 'cover-section'">

                            {{-- Section Header (for chapters) --}}
                            <template x-if="section.type === 'chapter' && section.chapter_number">
                                <div class="mb-4 pb-2 border-b border-gray-300">
                                    <span
                                        class="text-xs font-semibold text-gray-500 uppercase tracking-wider inline-flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        BAB <span x-text="section.chapter_number"></span>
                                    </span>
                                </div>
                            </template>

                            {{-- Render Elements --}}
                            <template x-for="(element, eIndex) in section.elements" :key="eIndex">
                                <div class="element-preview">

                                    {{-- Heading --}}
                                    <template x-if="element.type === 'heading'">
                                        <div :style="`
                                                                                                                            text-align: ${element.alignment || 'left'};
                                                                                                                            font-size: ${element.font_size || (20 - (element.level || 1) * 2)}pt;
                                                                                                                            font-weight: ${element.bold !== false ? 'bold' : 'normal'};
                                                                                                                            margin: ${element.level === 1 ? '2rem' : '1rem'} 0;
                                                                                                                            color: #000;
                                                                                                                        `"
                                            x-html="element.text || `&lt;Heading ${element.level || 1}&gt;`">
                                        </div>
                                    </template>

                                    {{-- Paragraph --}}
                                    <template x-if="element.type === 'paragraph'">
                                        <div :style="`
                                                                                                                            text-align: ${element.alignment || 'justify'};
                                                                                                                            text-indent: ${(element.first_line_indent || 0) * 37.8}px;
                                                                                                                            margin: 0.5rem 0;
                                                                                                                            color: #000;
                                                                                                                        `"
                                            x-html="element.text || '&lt;Paragraph text here...&gt;'">
                                        </div>
                                    </template>

                                    {{-- List --}}
                                    <template x-if="element.type === 'list'">
                                        <ul :class="element.list_type === 'number' ? 'list-decimal' : 'list-disc'"
                                            class="ml-6 my-3" style="color: #000;">
                                            <template
                                                x-for="(item, idx) in (element.items || ['Item 1', 'Item 2', 'Item 3'])"
                                                :key="idx">
                                                <li x-text="item" class="my-1.5"></li>
                                            </template>
                                        </ul>
                                    </template>

                                    {{-- Table --}}
                                    <template x-if="element.type === 'table'">
                                        <div class="overflow-x-auto my-4">
                                            <table class="min-w-full border-collapse border border-gray-400"
                                                style="color: #000;">
                                                <thead x-show="element.headers && element.headers.length > 0">
                                                    <tr class="bg-gray-100">
                                                        <template x-for="(header, idx) in (element.headers || [])"
                                                            :key="idx">
                                                            <th class="border border-gray-400 px-3 py-2 text-left font-bold text-sm"
                                                                x-text="header"></th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template
                                                        x-for="(row, rIdx) in (element.rows || [['Cell 1', 'Cell 2']])"
                                                        :key="rIdx">
                                                        <tr>
                                                            <template x-for="(cell, cIdx) in row"
                                                                :key="cIdx">
                                                                <td class="border border-gray-400 px-3 py-2 text-sm"
                                                                    x-text="cell"></td>
                                                            </template>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </template>

                                    {{-- Image Placeholder --}}
                                    <template x-if="element.type === 'image'">
                                        <div
                                            :style="`text-align: ${element.alignment || 'center'}; margin: 1.5rem 0;`">
                                            <div
                                                class="inline-block bg-gray-100 border-2 border-dashed border-gray-300 p-6 rounded-lg">
                                                <svg class="h-16 w-16 text-gray-400 mx-auto mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-xs text-gray-500 font-medium">
                                                    <span class="block">🖼️ Image</span>
                                                    <span class="text-gray-400"
                                                        x-text="element.path || 'path/to/image.png'"></span>
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1"
                                                    x-show="element.width || element.height">
                                                    <span x-text="element.width || 'auto'"></span>px ×
                                                    <span x-text="element.height || 'auto'"></span>px
                                                </p>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Page Break --}}
                                    <template x-if="element.type === 'page_break'">
                                        <div class="my-8 border-t-4 border-dashed border-blue-400 relative">
                                            <span
                                                class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-4 py-1 text-xs font-semibold text-blue-600 border border-blue-400 rounded-full shadow-sm">
                                                <svg class="inline h-3 w-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Page Break
                                            </span>
                                        </div>
                                    </template>

                                    {{-- Text Break --}}
                                    <template x-if="element.type === 'text_break'">
                                        <div
                                            :style="`height: ${(element.count || 1) * (formatting.font.size * formatting.font.line_spacing)}px;`">
                                        </div>
                                    </template>

                                    {{-- Horizontal Line --}}
                                    <template x-if="element.type === 'line'">
                                        <div class="my-4 flex justify-center">
                                            <hr
                                                :style="`
                                                                                                                                                width: ${element.width || 100}%;
                                                                                                                                                border: 0;
                                                                                                                                                border-top: 2px solid #${element.color || '000000'};
                                                                                                                                            `">
                                        </div>
                                    </template>

                                </div>
                            </template>

                            {{-- Section Separator --}}
                            <div x-show="sIndex < sections.length - 1" class="my-8"></div>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <div x-show="sections.length === 0"
                        class="text-center py-16 sm:py-24 text-gray-400 border-2 border-dashed border-gray-200 rounded-lg m-4">
                        <svg class="h-16 w-16 sm:h-20 sm:w-20 mx-auto mb-4 opacity-50" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-medium mb-2">Preview akan muncul di sini</p>
                        <p class="text-xs px-4">Mulai membangun template dengan menambahkan section dan elemen</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Preview Footer --}}
    <div
        class="bg-white dark:bg-gray-800 border-x border-b border-gray-200 dark:border-gray-700 rounded-b-lg px-4 py-2.5">
        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center">
                    <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span x-text="sections.length"></span> sections
                </span>
                <span class="inline-flex items-center">
                    <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span x-text="sections.reduce((sum, s) => sum + s.elements.length, 0)"></span> elements
                </span>
            </div>
            <div class="flex items-center space-x-2 text-xs">
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 font-medium">
                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-text="formatting.page_size"></span>
                </span>
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 font-medium">
                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span x-text="formatting.orientation"></span>
                </span>
            </div>
        </div>
    </div>
</div>

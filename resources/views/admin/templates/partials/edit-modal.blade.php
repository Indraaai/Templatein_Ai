{{-- Edit Element Modal --}}
<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" style="display: none;">

    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay --}}
        <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            @click="closeEditModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal panel --}}
        <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">

            <template x-if="editingElement">
                <div>
                    {{-- Modal Header --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modal-title">
                            <span
                                x-text="'Edit ' + editingElement.type.charAt(0).toUpperCase() + editingElement.type.slice(1)"></span>
                        </h3>
                        <button type="button" @click="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="px-4 py-5 sm:p-6 max-h-96 overflow-y-auto">

                        {{-- Heading Element --}}
                        <div x-show="editingElement.type === 'heading'" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Level</label>
                                <select x-model.number="editingElement.level"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option :value="1">Heading 1 (Largest)</option>
                                    <option :value="2">Heading 2</option>
                                    <option :value="3">Heading 3</option>
                                    <option :value="4">Heading 4</option>
                                    <option :value="5">Heading 5</option>
                                    <option :value="6">Heading 6 (Smallest)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Text</label>
                                <input type="text" x-model="editingElement.text"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alignment</label>
                                <select x-model="editingElement.style.alignment"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                    <option value="justify">Justify</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" x-model="editingElement.style.bold" id="heading-bold"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="heading-bold"
                                    class="ml-2 text-sm text-gray-700 dark:text-gray-300">Bold</label>
                            </div>
                        </div>

                        {{-- Paragraph Element --}}
                        <div x-show="editingElement.type === 'paragraph'" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Text</label>
                                <textarea x-model="editingElement.text" rows="4"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alignment</label>
                                <select x-model="editingElement.style.alignment"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                    <option value="justify">Justify</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Indent
                                    (cm)</label>
                                <input type="number" x-model.number="editingElement.style.indent" min="0"
                                    max="10" step="0.5"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- List Element --}}
                        <div x-show="editingElement.type === 'list'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">List
                                    Type</label>
                                <select x-model="editingElement.list_type"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="bullet">Bullet List (•)</option>
                                    <option value="number">Numbered List (1, 2, 3)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">List
                                    Items</label>
                                <div class="space-y-2">
                                    <template x-for="(item, index) in editingElement.items" :key="index">
                                        <div class="flex items-center space-x-2">
                                            <input type="text" x-model="editingElement.items[index]"
                                                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" @click="removeListItem(index)"
                                                class="p-2 text-red-500 hover:text-red-700">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="addListItem()"
                                    class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                    + Add Item
                                </button>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Indent
                                    (cm)</label>
                                <input type="number" x-model.number="editingElement.style.indent" min="0"
                                    max="10" step="0.5"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- Table Element --}}
                        <div x-show="editingElement.type === 'table'" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rows</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="number" x-model.number="editingElement.rows" readonly
                                            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                        <button type="button" @click="addTableRow()"
                                            class="px-2 py-1 text-sm bg-green-500 text-white rounded">+</button>
                                        <button type="button" @click="removeTableRow(editingElement.rows - 1)"
                                            class="px-2 py-1 text-sm bg-red-500 text-white rounded">-</button>
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Columns</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="number" x-model.number="editingElement.cols" readonly
                                            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                        <button type="button" @click="addTableCol()"
                                            class="px-2 py-1 text-sm bg-green-500 text-white rounded">+</button>
                                        <button type="button" @click="removeTableCol(editingElement.cols - 1)"
                                            class="px-2 py-1 text-sm bg-red-500 text-white rounded">-</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Table
                                    Data</label>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full border border-gray-300 dark:border-gray-600">
                                        <template x-for="(row, rowIndex) in editingElement.data"
                                            :key="rowIndex">
                                            <tr>
                                                <template x-for="(cell, colIndex) in row" :key="colIndex">
                                                    <td class="border border-gray-300 dark:border-gray-600 p-1">
                                                        <input type="text"
                                                            x-model="editingElement.data[rowIndex][colIndex]"
                                                            class="w-full text-sm border-0 focus:ring-0 dark:bg-gray-700 dark:text-white">
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Image Element --}}
                        <div x-show="editingElement.type === 'image'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image
                                    Path</label>
                                <input type="text" x-model="editingElement.path"
                                    placeholder="e.g., images/logo.jpg"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Relative path from storage/app/</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Width
                                        (cm)</label>
                                    <input type="number" x-model.number="editingElement.width" min="1"
                                        max="20" step="0.5"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Height
                                        (cm)</label>
                                    <input type="number" x-model.number="editingElement.height" min="1"
                                        max="20" step="0.5"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alignment</label>
                                <select x-model="editingElement.style.alignment"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                        </div>

                        {{-- Text Break Element --}}
                        <div x-show="editingElement.type === 'text_break'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Number
                                    of Breaks</label>
                                <input type="number" x-model.number="editingElement.count" min="1"
                                    max="10"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- Line Element --}}
                        <div x-show="editingElement.type === 'line'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Width
                                    (%)</label>
                                <input type="number" x-model.number="editingElement.width" min="10"
                                    max="100" step="10"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
                                <input type="color" x-model="editingElement.color"
                                    class="h-10 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- Page Break (no settings) --}}
                        <div x-show="editingElement.type === 'page_break'">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Page break has no configurable settings. It will insert a page break in the document.
                            </p>
                        </div>

                    </div>

                    {{-- Modal Footer --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                        <button type="button" @click="saveEditModal()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Changes
                        </button>
                        <button type="button" @click="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

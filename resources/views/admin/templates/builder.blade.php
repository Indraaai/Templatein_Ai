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
                <button type="button" id="previewButton"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <i class="fas fa-eye mr-1"></i>Preview
                </button>
                <button type="button" id="saveButton"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-200 text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <i class="fas fa-save mr-1"></i><span id="saveButtonText">Simpan</span>
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
                    @include('admin.templates.builder.formatting-panel')

                    <!-- Quick Templates -->
                    @include('admin.templates.builder.quick-templates')

                    <!-- Add/Edit Section -->
                    @include('admin.templates.builder.section-form')

                    <!-- Template Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="isActive" {{ $template->is_active ? 'checked' : '' }}
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="text-sm font-medium text-gray-700">Template Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-6">Template dapat digunakan oleh mahasiswa</p>
                    </div>
                </div>

                <!-- Right Panel - Sections List -->
                <div class="lg:col-span-2">
                    @include('admin.templates.builder.sections-list')
                </div>

            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.templates.builder.modals.heading-manager')
    @include('admin.templates.builder.modals.content-manager')

    @push('styles')
        <!-- Quill Editor CSS -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <!-- Builder Custom CSS -->
        @vite(['resources/css/builder.css'])
        <!-- Inline Styles -->
        <style>
            .sortable-ghost {
                opacity: 0.4;
                background: #e0e7ff;
            }

            .quill-editor-small {
                height: 150px;
            }

            .quill-editor-large {
                height: 300px;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Quill Editor JS -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <!-- SortableJS -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

        <script>
            // Global configuration
            window.builderConfig = {
                templateId: {{ $template->id }},
                csrfToken: '{{ csrf_token() }}',
                saveUrl: '{{ route('admin.templates.save-builder', $template) }}',
                redirectUrl: '{{ route('admin.templates.show', $template) }}',
                existingRules: @json($template->template_rules ?? ['formatting' => [], 'sections' => []])
            };
        </script>

        <!-- Main Builder Script -->
        @vite(['resources/js/template-builder/builder-main.js'])
    @endpush
</x-app-layout>

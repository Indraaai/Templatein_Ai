<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Template') }}
            </h2>
            <a href="{{ route('student.templates.index') }}"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                ← Kembali ke Daftar Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Template Detail Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8">
                    <!-- Header with Icon -->
                    <div class="flex items-start gap-6 mb-6">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-xl flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $template->name }}
                                </h3>
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    {{ strtoupper($template->type) }}
                                </span>
                            </div>
                            @if ($template->description)
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    {{ $template->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Template Information -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4 uppercase tracking-wide">
                            Informasi Template
                        </h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <dt
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                    Fakultas
                                </dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $template->faculty->name }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <dt
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                    Program Studi
                                </dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $template->programStudy->name }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <dt
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                    Tipe File
                                </dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ strtoupper($template->type) }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <dt
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                    Tanggal Dibuat
                                </dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $template->created_at->format('d F Y, H:i') }}
                                </dd>
                            </div>
                            @if ($template->original_filename)
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 md:col-span-2">
                                    <dt
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                        Nama File
                                    </dt>
                                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100 break-all">
                                        {{ $template->original_filename }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Content Preview (if available) -->
                    @if ($template->content)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                            <h4
                                class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4 uppercase tracking-wide">
                                Konten Template
                            </h4>
                            <div
                                class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 max-h-96 overflow-y-auto prose dark:prose-invert max-w-none">
                                <pre class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap font-mono">{{ Str::limit($template->content, 2000) }}</pre>
                                @if (strlen($template->content) > 2000)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-4 italic">
                                        ... Konten terpotong. Download file untuk melihat selengkapnya.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Rules Preview (if available) -->
                    @if ($template->rules)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                            <h4
                                class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4 uppercase tracking-wide">
                                Aturan Template
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                                <pre class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ json_encode($template->rules, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('student.templates.download', $template) }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Template
                            </a>
                            @if ($template->file_path)
                                <a href="{{ route('student.templates.preview', $template) }}" target="_blank"
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div
                class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                            Cara Menggunakan Template
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Klik tombol "Download Template" untuk mengunduh file template</li>
                                <li>Buka file dengan aplikasi yang sesuai (Microsoft Word/LibreOffice untuk DOCX)</li>
                                <li>Isi dokumen sesuai dengan format yang telah ditentukan</li>
                                <li>Simpan dokumen Anda setelah selesai mengedit</li>
                                <li>Anda dapat menggunakan fitur "Cek Dokumen" untuk memverifikasi format</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

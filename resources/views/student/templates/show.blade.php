<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-blue-600 mr-3"></i>Detail Template
                </h2>
                <p class="text-gray-600 mt-1 text-sm">Informasi lengkap template dokumen</p>
            </div>
            <a href="{{ route('student.templates.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Template Detail Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-8">
                    <!-- Header with Icon -->
                    <div class="flex items-start gap-6 mb-8">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                            <i class="fas fa-file-alt text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-3xl font-bold text-gray-900">
                                    {{ $template->name }}
                                </h3>
                                <span
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg bg-green-100 text-green-800">
                                    {{ strtoupper($template->type) }}
                                </span>
                            </div>
                            @if ($template->description)
                                <p class="text-gray-600 leading-relaxed text-base">
                                    {{ $template->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Template Information -->
                    <div class="border-t border-gray-200 pt-8 mb-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i>Informasi Template
                        </h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-100">
                                <dt
                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 flex items-center">
                                    <i class="fas fa-building mr-2 text-gray-400"></i>Fakultas
                                </dt>
                                <dd class="text-base font-bold text-gray-900">
                                    {{ $template->faculty->name }}
                                </dd>
                            </div>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-100">
                                <dt
                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 flex items-center">
                                    <i class="fas fa-graduation-cap mr-2 text-gray-400"></i>Program Studi
                                </dt>
                                <dd class="text-base font-bold text-gray-900">
                                    {{ $template->programStudy->name }}
                                </dd>
                            </div>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-100">
                                <dt
                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 flex items-center">
                                    <i class="fas fa-file-code mr-2 text-gray-400"></i>Tipe File
                                </dt>
                                <dd class="text-base font-bold text-gray-900">
                                    {{ strtoupper($template->type) }}
                                </dd>
                            </div>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-100">
                                <dt
                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Tanggal Dibuat
                                </dt>
                                <dd class="text-base font-bold text-gray-900">
                                    {{ $template->created_at->format('d F Y, H:i') }}
                                </dd>
                            </div>
                            @if ($template->original_filename)
                                <div
                                    class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-100 md:col-span-2">
                                    <dt
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 flex items-center">
                                        <i class="fas fa-file mr-2 text-gray-400"></i>Nama File
                                    </dt>
                                    <dd class="text-base font-bold text-gray-900 break-all">
                                        {{ $template->original_filename }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Content Preview (if available) -->
                    @if ($template->content)
                        <div class="border-t border-gray-200 pt-8 mb-8">
                            <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-file-code text-purple-500 mr-3"></i>Konten Template
                            </h4>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-xl p-6 border border-gray-200 max-h-96 overflow-y-auto">
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap font-mono leading-relaxed">{{ Str::limit($template->content, 2000) }}</pre>
                                @if (strlen($template->content) > 2000)
                                    <p class="text-xs text-gray-500 mt-4 italic flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>Konten terpotong. Download file untuk
                                        melihat selengkapnya.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Rules Preview (if available) -->
                    @if ($template->rules)
                        <div class="border-t border-gray-200 pt-8 mb-8">
                            <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-list-check text-green-500 mr-3"></i>Aturan Template
                            </h4>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-green-50 rounded-xl p-6 border border-gray-200">
                                <pre class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ json_encode($template->rules, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 pt-8">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4">Aksi Template</h4>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('student.templates.download', $template) }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-lg font-semibold text-center transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                <i class="fas fa-download text-lg"></i>
                                Download Template
                            </a>
                            @if ($template->file_path)
                                <a href="{{ route('student.templates.preview', $template) }}" target="_blank"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3.5 rounded-lg font-semibold text-center transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-eye text-lg"></i>
                                    Preview File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div
                class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-xl p-6 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            Cara Menggunakan Template
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full mr-3 flex-shrink-0 mt-0.5">1</span>
                                <p class="text-gray-700">Klik tombol "Download Template" untuk mengunduh file template
                                </p>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full mr-3 flex-shrink-0 mt-0.5">2</span>
                                <p class="text-gray-700">Buka file dengan aplikasi yang sesuai (Microsoft
                                    Word/LibreOffice untuk DOCX)</p>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full mr-3 flex-shrink-0 mt-0.5">3</span>
                                <p class="text-gray-700">Isi dokumen sesuai dengan format yang telah ditentukan</p>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full mr-3 flex-shrink-0 mt-0.5">4</span>
                                <p class="text-gray-700">Simpan dokumen Anda setelah selesai mengedit</p>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 bg-yellow-500 text-white text-xs font-bold rounded-full mr-3 flex-shrink-0 mt-0.5">5</span>
                                <p class="text-gray-700">Anda dapat menggunakan fitur "Cek Dokumen" untuk memverifikasi
                                    format</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-blue-600 mr-3"></i>Template Dokumen
                </h2>
                <p class="text-gray-600 mt-1 text-sm">Unduh template dokumen sesuai kebutuhan Anda</p>
            </div>
            <a href="{{ route('student.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div
                class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-6 mb-8 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Informasi Template
                        </h3>
                        <p class="text-gray-700 leading-relaxed">
                            Template di bawah ini khusus untuk <span
                                class="font-semibold text-blue-700">{{ auth()->user()->faculty->name }}</span> -
                            <span class="font-semibold text-blue-700">{{ auth()->user()->programStudy->name }}</span>.
                            Anda dapat mengunduh dan menggunakan template sesuai kebutuhan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Templates Grid -->
            @if ($templates->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($templates as $template)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <!-- Template Icon & Type Badge -->
                                <div class="flex items-start justify-between mb-4">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-file-alt text-white text-2xl"></i>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ strtoupper($template->type) }}
                                    </span>
                                </div>

                                <!-- Template Name -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                    {{ $template->name }}
                                </h3>

                                <!-- Template Description -->
                                @if ($template->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                        {{ $template->description }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic mb-4">
                                        Tidak ada deskripsi
                                    </p>
                                @endif

                                <!-- Metadata -->
                                <div class="border-t border-gray-200 pt-4 mb-4 space-y-2">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-calendar-alt w-4 mr-2 text-gray-400"></i>
                                        Dibuat: {{ $template->created_at->format('d M Y') }}
                                    </div>
                                    @if ($template->original_filename)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-file w-4 mr-2 text-gray-400"></i>
                                            {{ Str::limit($template->original_filename, 30) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="{{ route('student.templates.download', $template) }}"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                                        <i class="fas fa-download"></i>
                                        Download
                                    </a>
                                    <a href="{{ route('student.templates.show', $template) }}"
                                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-all duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $templates->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-inbox text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            Belum Ada Template Tersedia
                        </h3>
                        <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                            Belum ada template dokumen yang tersedia untuk fakultas dan program studi Anda saat ini.
                            Silakan hubungi admin untuk informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

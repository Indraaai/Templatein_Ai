<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-invoice text-blue-600 mr-3"></i>Detail Dokumen
                </h2>
                <p class="text-gray-600 mt-1 text-sm">Informasi lengkap dokumen dan hasil pemeriksaan AI</p>
            </div>
            <a href="{{ route('student.documents.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Document Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-3"></i>Informasi Dokumen
                            </h3>

                            <dl class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-semibold text-gray-600 mb-1">Nama File</dt>
                                    <dd class="text-base text-gray-900 font-medium">{{ $document->original_filename }}
                                    </dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-semibold text-gray-600 mb-1">Template</dt>
                                    <dd class="text-base text-gray-900 font-medium">
                                        {{ $document->template->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-semibold text-gray-600 mb-1">Status Pemeriksaan</dt>
                                    <dd class="mt-2">
                                        <span
                                            class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                                            {{ $document->status == 'completed' ? 'bg-green-100 text-green-800' : ($document->status == 'processing' ? 'bg-yellow-100 text-yellow-800' : ($document->status == 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            @if ($document->status == 'completed')
                                                <i class="fas fa-check-circle mr-2"></i>
                                            @elseif($document->status == 'processing')
                                                <i class="fas fa-spinner mr-2"></i>
                                            @elseif($document->status == 'failed')
                                                <i class="fas fa-times-circle mr-2"></i>
                                            @endif
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-semibold text-gray-600 mb-1">Upload</dt>
                                    <dd class="text-base text-gray-900 font-medium flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                        {{ $document->created_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                                @if ($document->ai_checked_at)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <dt class="text-sm font-semibold text-gray-600 mb-1">Diperiksa AI</dt>
                                        <dd class="text-base text-gray-900 font-medium flex items-center">
                                            <i class="fas fa-robot mr-2 text-blue-400"></i>
                                            {{ $document->ai_checked_at->format('d M Y H:i') }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-clipboard-check text-green-500 mr-3"></i>Status Approval
                            </h3>

                            <dl class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-semibold text-gray-600 mb-2">Status</dt>
                                    <dd>
                                        <span
                                            class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold w-full justify-center
                                            {{ $document->approval_status == 'approved' ? 'bg-green-100 text-green-800' : ($document->approval_status == 'rejected' ? 'bg-red-100 text-red-800' : ($document->approval_status == 'revision' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                            @if ($document->approval_status == 'pending')
                                                <i class="fas fa-clock mr-2"></i>Menunggu Review
                                            @elseif($document->approval_status == 'approved')
                                                <i class="fas fa-check-circle mr-2"></i>Disetujui
                                            @elseif($document->approval_status == 'rejected')
                                                <i class="fas fa-times-circle mr-2"></i>Ditolak
                                            @elseif($document->approval_status == 'revision')
                                                <i class="fas fa-exclamation-triangle mr-2"></i>Perlu Revisi
                                            @endif
                                        </span>
                                    </dd>
                                </div>
                                @if ($document->checker)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <dt class="text-sm font-semibold text-gray-600 mb-1">Direview Oleh</dt>
                                        <dd class="text-base text-gray-900 font-medium flex items-center">
                                            <i class="fas fa-user-check mr-2 text-green-400"></i>
                                            {{ $document->checker->name }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($document->checked_at)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <dt class="text-sm font-semibold text-gray-600 mb-1">Waktu Review</dt>
                                        <dd class="text-base text-gray-900 font-medium flex items-center">
                                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                                            {{ $document->checked_at->format('d M Y H:i') }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($document->admin_notes)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4">
                                        <dt class="text-sm font-semibold text-yellow-800 mb-2 flex items-center">
                                            <i class="fas fa-sticky-note mr-2"></i>Catatan Admin
                                        </dt>
                                        <dd class="text-sm text-yellow-900">
                                            {{ $document->admin_notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4">Aksi Dokumen</h4>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('student.documents.download', $document) }}"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-download mr-2"></i>
                                Download Original
                            </a>

                            @if ($document->hasCorrectedFile())
                                <a href="{{ route('student.documents.download-corrected', $document) }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Download Corrected
                                </a>
                            @endif

                            @if ($document->ai_feedback)
                                <a href="{{ route('student.documents.download-feedback', $document) }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    Download Feedback
                                </a>
                            @endif

                            @if ($document->status == 'completed')
                                <form action="{{ route('student.documents.recheck', $document) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg font-semibold transition-all duration-200"
                                        onclick="return confirm('Periksa ulang dokumen ini dengan AI?')">
                                        <i class="fas fa-redo mr-2"></i>
                                        Periksa Ulang
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('student.documents.destroy', $document) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg font-semibold transition-all duration-200"
                                    onclick="return confirm('Hapus dokumen ini?')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Score Card -->
            @if ($document->ai_score !== null)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-chart-line text-blue-500 mr-3"></i>Skor Pemeriksaan AI
                        </h3>

                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <!-- Score Circle -->
                            <div class="flex-shrink-0">
                                <div class="relative w-48 h-48">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="96" cy="96" r="88" fill="none" stroke="#e5e7eb"
                                            stroke-width="16" />
                                        <circle cx="96" cy="96" r="88" fill="none"
                                            class="{{ $document->isPassed() ? 'stroke-green-600' : 'stroke-red-600' }}"
                                            stroke-width="16" stroke-dasharray="{{ 2 * 3.14159 * 88 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 88 * (1 - $document->ai_score / 100) }}"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span
                                            class="text-5xl font-bold {{ $document->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($document->ai_score, 1) }}
                                        </span>
                                        <span class="text-base text-gray-500 font-medium">/ 100</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Score Info -->
                            <div class="flex-1 text-center md:text-left">
                                @if ($document->isPassed())
                                    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                                            <h4 class="text-xl font-bold text-green-800">Dokumen Memenuhi Standar</h4>
                                        </div>
                                        <p class="text-green-700 leading-relaxed">
                                            Selamat! Dokumen Anda telah memenuhi kriteria pemeriksaan AI dan siap untuk
                                            direview oleh admin.
                                        </p>
                                    </div>
                                @else
                                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                                            <h4 class="text-xl font-bold text-red-800">Dokumen Perlu Perbaikan</h4>
                                        </div>
                                        <p class="text-red-700 leading-relaxed">
                                            Dokumen Anda memerlukan perbaikan sesuai dengan feedback AI di bawah ini
                                            untuk memenuhi standar yang ditetapkan.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- AI Feedback Card -->
            @if ($document->ai_feedback)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-comment-dots text-purple-500 mr-3"></i>Hasil Analisis AI
                        </h3>

                        <div class="prose max-w-none">
                            <div
                                class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                                <div class="text-gray-800 leading-relaxed whitespace-pre-line">
                                    {{ $document->ai_feedback }}
                                </div>
                            </div>
                        </div>

                        @if ($document->hasCorrectedFile())
                            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-lightbulb text-blue-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-semibold text-blue-900 mb-1">File Koreksi Tersedia!
                                        </h4>
                                        <p class="text-blue-800 leading-relaxed">
                                            Download file yang sudah diperbaiki oleh AI untuk melihat perbaikan yang
                                            disarankan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Processing Status -->
            @if ($document->status == 'processing')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Dokumen sedang diproses</h3>
                            <p class="mt-2 text-sm text-yellow-700">
                                AI sedang menganalisis dokumen Anda. Ini mungkin memakan waktu beberapa menit. Silakan
                                refresh halaman ini untuk melihat hasil.
                            </p>
                            <div class="mt-4">
                                <button onclick="location.reload()"
                                    class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Failed Status -->
            @if ($document->status == 'failed')
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Pemeriksaan gagal</h3>
                            <p class="mt-2 text-sm text-red-700">
                                Terjadi kesalahan saat memproses dokumen Anda. Silakan coba upload ulang atau hubungi
                                admin.
                            </p>
                            <div class="mt-4">
                                <form action="{{ route('student.documents.recheck', $document) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Coba Lagi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

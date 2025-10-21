<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Dokumen') }}
            </h2>
            <a href="{{ route('student.documents.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Document Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dokumen</h3>

                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama File</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->original_filename }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Template</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->template->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status Pemeriksaan</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $document->status == 'completed' ? 'bg-green-100 text-green-800' : ($document->status == 'processing' ? 'bg-yellow-100 text-yellow-800' : ($document->status == 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Upload</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $document->created_at->format('d M Y H:i') }}</dd>
                                </div>
                                @if ($document->ai_checked_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Diperiksa AI</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $document->ai_checked_at->format('d M Y H:i') }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Approval</h3>

                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $document->approval_status == 'approved' ? 'bg-green-100 text-green-800' : ($document->approval_status == 'rejected' ? 'bg-red-100 text-red-800' : ($document->approval_status == 'revision' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                            @if ($document->approval_status == 'pending')
                                                ⏳ Menunggu Review
                                            @elseif($document->approval_status == 'approved')
                                                ✓ Disetujui
                                            @elseif($document->approval_status == 'rejected')
                                                ✗ Ditolak
                                            @elseif($document->approval_status == 'revision')
                                                ⚠ Perlu Revisi
                                            @endif
                                        </span>
                                    </dd>
                                </div>
                                @if ($document->checker)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Direview Oleh</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->checker->name }}</dd>
                                    </div>
                                @endif
                                @if ($document->checked_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Waktu Review</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $document->checked_at->format('d M Y H:i') }}</dd>
                                    </div>
                                @endif
                                @if ($document->admin_notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Catatan Admin</dt>
                                        <dd class="mt-1 text-sm text-gray-900 bg-yellow-50 p-3 rounded">
                                            {{ $document->admin_notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('student.documents.download', $document) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Original
                        </a>

                        @if ($document->hasCorrectedFile())
                            <a href="{{ route('student.documents.download-corrected', $document) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Download Corrected
                            </a>
                        @endif

                        @if ($document->ai_feedback)
                            <a href="{{ route('student.documents.download-feedback', $document) }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Feedback
                            </a>
                        @endif

                        @if ($document->status == 'completed')
                            <form action="{{ route('student.documents.recheck', $document) }}" method="POST"
                                class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition"
                                    onclick="return confirm('Periksa ulang dokumen ini dengan AI?')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Periksa Ulang
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('student.documents.destroy', $document) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                                onclick="return confirm('Hapus dokumen ini?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- AI Score Card -->
            @if ($document->ai_score !== null)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Skor Pemeriksaan AI</h3>

                        <div class="flex items-center justify-center mb-6">
                            <div class="relative w-48 h-48">
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="96" cy="96" r="88" fill="none" stroke="#e5e7eb"
                                        stroke-width="12" />
                                    <circle cx="96" cy="96" r="88" fill="none"
                                        class="{{ $document->isPassed() ? 'stroke-green-600' : 'stroke-red-600' }}"
                                        stroke-width="12" stroke-dasharray="{{ 2 * 3.14159 * 88 }}"
                                        stroke-dashoffset="{{ 2 * 3.14159 * 88 * (1 - $document->ai_score / 100) }}"
                                        stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span
                                        class="text-4xl font-bold {{ $document->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($document->ai_score, 1) }}
                                    </span>
                                    <span class="text-sm text-gray-500">/ 100</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            @if ($document->isPassed())
                                <p class="text-green-600 font-semibold">✓ Dokumen memenuhi standar</p>
                                <p class="text-sm text-gray-600 mt-1">Dokumen Anda telah memenuhi kriteria pemeriksaan
                                    AI</p>
                            @else
                                <p class="text-red-600 font-semibold">⚠ Dokumen perlu perbaikan</p>
                                <p class="text-sm text-gray-600 mt-1">Dokumen Anda memerlukan perbaikan sesuai feedback
                                    AI</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- AI Feedback Card -->
            @if ($document->ai_feedback)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Analisis AI</h3>

                        <div class="prose max-w-none">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                {!! nl2br(e($document->ai_feedback)) !!}
                            </div>
                        </div>

                        @if ($document->hasCorrectedFile())
                            <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>File koreksi tersedia!</strong> Download file yang sudah diperbaiki
                                            oleh AI.
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

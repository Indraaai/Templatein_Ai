<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Review Dokumen') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Detail dan analisis dokumen mahasiswa
                </p>
            </div>
            <a href="{{ route('admin.documents.index') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 border border-gray-200 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Student & Document Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Student Info -->
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Mahasiswa
                        </h3>
                        <div class="flex items-center mb-6">
                            <div
                                class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-xl">
                                    {{ substr($document->user->name, 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-bold text-gray-900">{{ $document->user->name }}</div>
                                <div class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $document->user->email }}
                                </div>
                            </div>
                        </div>
                        <dl class="space-y-3">
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <dt class="text-sm font-medium text-gray-600">Role:</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        {{ ucfirst($document->user->role) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <dt class="text-sm font-medium text-gray-600">Total Upload:</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $document->user->documentChecks()->count() }} dokumen</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Document Info -->
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Informasi Dokumen
                        </h3>
                        <dl class="space-y-4">
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama File
                                </dt>
                                <dd class="text-sm font-medium text-gray-900 break-all">
                                    {{ $document->original_filename }}</dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Template
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $document->template->name ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status
                                    Proses</dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $document->status == 'completed' ? 'bg-emerald-100 text-emerald-800' : ($document->status == 'processing' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Waktu
                                    Upload</dt>
                                <dd class="text-sm font-medium text-gray-900 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $document->created_at->format('d M Y H:i') }}
                                </dd>
                            </div>
                            @if ($document->ai_checked_at)
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">AI
                                        Check</dt>
                                    <dd class="text-sm font-medium text-gray-900 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $document->ai_checked_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- AI Score & Feedback -->
            @if ($document->ai_score !== null)
                <div
                    class="bg-gradient-to-br from-white to-gray-50 overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Analisis AI
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Score Circle -->
                            <div class="flex items-center justify-center bg-white rounded-xl p-6 shadow-sm">
                                <div class="relative w-44 h-44">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="88" cy="88" r="80" fill="none" stroke="#f3f4f6"
                                            stroke-width="12" />
                                        <circle cx="88" cy="88" r="80" fill="none"
                                            class="{{ $document->isPassed() ? 'stroke-emerald-500' : 'stroke-rose-500' }}"
                                            stroke-width="12" stroke-dasharray="{{ 2 * 3.14159 * 80 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 80 * (1 - $document->ai_score / 100) }}"
                                            stroke-linecap="round"
                                            style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span
                                            class="text-4xl font-black {{ $document->isPassed() ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ number_format($document->ai_score, 1) }}
                                        </span>
                                        <span class="text-sm text-gray-500 font-semibold mt-1">/ 100</span>
                                        @if ($document->isPassed())
                                            <span
                                                class="mt-2 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">LULUS</span>
                                        @else
                                            <span
                                                class="mt-2 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold">TIDAK
                                                LULUS</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback -->
                            <div class="lg:col-span-2">
                                <div class="bg-white rounded-xl p-5 shadow-sm h-full">
                                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Feedback AI
                                    </h4>
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-lg p-4 border border-gray-200 max-h-72 overflow-y-auto custom-scrollbar">
                                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                            {!! nl2br(e($document->ai_feedback)) !!}
                                        </div>
                                    </div>
                                    @if ($document->hasCorrectedFile())
                                        <div
                                            class="mt-4 flex items-center gap-2 text-sm text-emerald-700 bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-200">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-semibold">File koreksi tersedia</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- File Downloads -->
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download File
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.documents.download', $document) }}"
                            class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Original
                        </a>

                        @if ($document->hasCorrectedFile())
                            <a href="{{ route('admin.documents.download-corrected', $document) }}"
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-emerald-600 to-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Download Corrected
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review Actions -->
            @if ($document->approval_status == 'pending' && $document->status == 'completed')
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Review Dokumen
                        </h3>

                        <form id="reviewForm" method="POST">
                            @csrf

                            <div class="mb-6">
                                <label for="admin_notes"
                                    class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Catatan Review (Opsional)
                                </label>
                                <textarea name="admin_notes" id="admin_notes" rows="4"
                                    class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                                    placeholder="Tambahkan catatan untuk mahasiswa..."></textarea>
                                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Catatan ini akan terlihat oleh mahasiswa
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button type="button" onclick="submitReview('approve')"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Approve Dokumen
                                </button>

                                <button type="button" onclick="submitReview('revision')" <button type="button"
                                    onclick="submitReview('revision')"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Minta Revisi
                                </button>

                                <button type="button" onclick="submitReview('reject')"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-600 to-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-rose-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Reject Dokumen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- Review History -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Status Review
                        </h3>
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 p-2 rounded-lg {{ $document->approval_status == 'approved' ? 'bg-emerald-100' : ($document->approval_status == 'rejected' ? 'bg-rose-100' : 'bg-amber-100') }}">
                                    @if ($document->approval_status == 'approved')
                                        <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($document->approval_status == 'rejected')
                                        <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-base font-bold text-gray-900">
                                        {{ ucfirst($document->approval_status) }}
                                        @if ($document->checker)
                                            <span class="text-sm font-normal text-gray-600">oleh
                                                {{ $document->checker->name }}</span>
                                        @endif
                                    </p>
                                    @if ($document->checked_at)
                                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $document->checked_at->format('d M Y H:i') }}
                                        </p>
                                    @endif
                                    @if ($document->admin_notes)
                                        <div class="mt-4 bg-white p-4 rounded-lg border border-gray-200">
                                            <p
                                                class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                                Catatan Admin</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ $document->admin_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danger Zone -->
            <div
                class="bg-gradient-to-br from-rose-50 to-red-50 overflow-hidden rounded-xl shadow-sm border-2 border-rose-200">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-rose-900 mb-2">Danger Zone</h3>
                            <p class="text-sm text-rose-700 mb-4">Menghapus dokumen ini akan menghilangkan semua data
                                terkait secara permanen dan tidak dapat dikembalikan.</p>
                            <form action="{{ route('admin.documents.destroy', $document) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-rose-600 border-2 border-rose-700 rounded-lg font-bold text-sm text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-all shadow hover:shadow-md"
                                    onclick="return confirm('⚠️ PERINGATAN: Menghapus dokumen ini akan menghapus semua data terkait. Lanjutkan?')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Dokumen Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function submitReview(action) {
                const form = document.getElementById('reviewForm');
                const notes = document.getElementById('admin_notes').value;

                let confirmMsg = '';
                let url = '';

                switch (action) {
                    case 'approve':
                        confirmMsg = 'Approve dokumen ini?';
                        url = '{{ route('admin.documents.approve', $document) }}';
                        break;
                    case 'revision':
                        confirmMsg = 'Minta mahasiswa untuk merevisi dokumen ini?';
                        url = '{{ route('admin.documents.request-revision', $document) }}';
                        break;
                    case 'reject':
                        confirmMsg = 'Reject dokumen ini?';
                        url = '{{ route('admin.documents.reject', $document) }}';
                        break;
                }

                if (!confirm(confirmMsg)) {
                    return;
                }

                form.action = url;
                form.submit();
            }
        </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Review Dokumen') }}
            </h2>
            <a href="{{ route('admin.documents.index') }}"
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
            <!-- Student & Document Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Student Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h3>
                        <div class="flex items-center mb-4">
                            <div
                                class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 font-medium text-xl">
                                    {{ substr($document->user->name, 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-medium text-gray-900">{{ $document->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $document->user->email }}</div>
                            </div>
                        </div>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Role:</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst($document->user->role) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Total Upload:</dt>
                                <dd class="text-sm text-gray-900">{{ $document->user->documentChecks()->count() }}
                                    dokumen</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Document Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
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
                                <dt class="text-sm font-medium text-gray-500">Status Proses</dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $document->status == 'completed' ? 'bg-green-100 text-green-800' : ($document->status == 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Upload</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('d M Y H:i') }}
                                </dd>
                            </div>
                            @if ($document->ai_checked_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">AI Check</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $document->ai_checked_at->format('d M Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- AI Score & Feedback -->
            @if ($document->ai_score !== null)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Analisis AI</h3>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Score Circle -->
                            <div class="flex items-center justify-center">
                                <div class="relative w-40 h-40">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="80" cy="80" r="70" fill="none" stroke="#e5e7eb"
                                            stroke-width="10" />
                                        <circle cx="80" cy="80" r="70" fill="none"
                                            class="{{ $document->isPassed() ? 'stroke-green-600' : 'stroke-red-600' }}"
                                            stroke-width="10" stroke-dasharray="{{ 2 * 3.14159 * 70 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 70 * (1 - $document->ai_score / 100) }}"
                                            stroke-linecap="round" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span
                                            class="text-3xl font-bold {{ $document->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($document->ai_score, 1) }}
                                        </span>
                                        <span class="text-sm text-gray-500">/ 100</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback -->
                            <div class="lg:col-span-2">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Feedback AI:</h4>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 max-h-64 overflow-y-auto">
                                    <div class="prose prose-sm max-w-none">
                                        {!! nl2br(e($document->ai_feedback)) !!}
                                    </div>
                                </div>
                                @if ($document->hasCorrectedFile())
                                    <div class="mt-3 text-sm text-blue-600">
                                        ✓ File koreksi tersedia
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- File Downloads -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Download File</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.documents.download', $document) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Original
                        </a>

                        @if ($document->hasCorrectedFile())
                            <a href="{{ route('admin.documents.download-corrected', $document) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Dokumen</h3>

                        <form id="reviewForm" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan Review (Opsional)
                                </label>
                                <textarea name="admin_notes" id="admin_notes" rows="4"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Tambahkan catatan untuk mahasiswa..."></textarea>
                                <p class="mt-1 text-sm text-gray-500">
                                    Catatan ini akan terlihat oleh mahasiswa
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button type="button" onclick="submitReview('approve')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Approve Dokumen
                                </button>

                                <button type="button" onclick="submitReview('revision')"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Minta Revisi
                                </button>

                                <button type="button" onclick="submitReview('reject')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Review</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if ($document->approval_status == 'approved')
                                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($document->approval_status == 'rejected')
                                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($document->approval_status) }}
                                        @if ($document->checker)
                                            oleh {{ $document->checker->name }}
                                        @endif
                                    </p>
                                    @if ($document->checked_at)
                                        <p class="text-sm text-gray-500">
                                            {{ $document->checked_at->format('d M Y H:i') }}</p>
                                    @endif
                                    @if ($document->admin_notes)
                                        <p class="mt-2 text-sm text-gray-700 bg-white p-3 rounded">
                                            {{ $document->admin_notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danger Zone -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
                    <form action="{{ route('admin.documents.destroy', $document) }}" method="POST"
                        class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                            onclick="return confirm('PERINGATAN: Menghapus dokumen ini akan menghapus semua data terkait. Lanjutkan?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Dokumen
                        </button>
                    </form>
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

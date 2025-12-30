<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Review Dokumen Mahasiswa') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kelola dan review dokumen yang diupload mahasiswa
                </p>
            </div>
            <a href="{{ route('admin.documents.statistics') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Lihat Statistik
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-r-lg shadow-sm animate-fadeIn"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-r-lg shadow-sm animate-fadeIn"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl p-3 shadow-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Dokumen</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl p-3 shadow-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Review</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['pending'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl p-3 shadow-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['approved'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl p-3 shadow-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Bulk Actions -->
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6">
                    <!-- Filter Form -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter & Pencarian
                        </h3>
                        <form method="GET" action="{{ route('admin.documents.index') }}"
                            class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1 min-w-[200px]">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari dokumen atau mahasiswa..."
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition">
                                </div>
                            </div>
                            <div class="w-full md:w-48">
                                <select name="status"
                                    class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition py-2.5">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        ⏳ Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        ✓ Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        ✗ Rejected</option>
                                    <option value="revision" {{ request('status') == 'revision' ? 'selected' : '' }}>
                                        ✎ Revision</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Filter
                                    </span>
                                </button>
                                @if (request()->hasAny(['search', 'status']))
                                    <a href="{{ route('admin.documents.index') }}"
                                        class="px-6 py-2.5 bg-gray-100 border border-gray-200 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Reset
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <form id="bulkApproveForm" method="POST" action="{{ route('admin.documents.bulk-approve') }}"
                        class="hidden">
                        @csrf
                        <input type="hidden" name="document_ids" id="bulkDocumentIds">
                    </form>
                    <div id="bulkActions" class="hidden border-t border-gray-200 pt-4">
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center gap-3 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-blue-900">
                                    <span id="selectedCount" class="font-bold">0</span> dokumen dipilih
                                </span>
                            </div>
                            <div class="flex gap-2 flex-wrap">
                                <button type="button" onclick="submitBulkApprove()"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 border border-transparent rounded-lg font-medium text-xs text-white hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Approve Semua
                                </button>
                                <button type="button" onclick="clearSelection()"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-xs text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            @if ($documents->count() > 0)
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-slate-50">
                                <tr>
                                    <th scope="col" class="w-12 px-6 py-4 text-left">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2 transition">
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Mahasiswa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Dokumen
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Template
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Skor AI
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Upload
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($documents as $document)
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            @if ($document->approval_status == 'pending' && $document->status == 'completed')
                                                <input type="checkbox"
                                                    class="document-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2 transition"
                                                    value="{{ $document->id }}" onchange="updateBulkActions()">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-11 w-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-semibold text-sm">
                                                        {{ substr($document->user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $document->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $document->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($document->original_filename, 30) }}</div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $document->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-700 font-medium">
                                                {{ $document->template->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($document->ai_score !== null)
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center">
                                                        <span
                                                            class="text-lg font-bold {{ $document->isPassed() ? 'text-emerald-600' : 'text-rose-600' }}">
                                                            {{ number_format($document->ai_score, 1) }}
                                                        </span>
                                                        <span class="text-xs text-gray-400 ml-0.5">/100</span>
                                                    </div>
                                                    @if ($document->isPassed())
                                                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $document->approval_status == 'approved' ? 'bg-emerald-100 text-emerald-800' : ($document->approval_status == 'rejected' ? 'bg-rose-100 text-rose-800' : ($document->approval_status == 'revision' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800')) }}">
                                                {{ ucfirst($document->approval_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            {{ $document->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.documents.show', $document) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium shadow-sm">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Review
                                                </a>
                                                <form action="{{ route('admin.documents.destroy', $document) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition-colors text-xs font-medium shadow-sm"
                                                        onclick="return confirm('Hapus dokumen ini?')">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="p-12 text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gray-100 to-slate-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum ada dokumen</h3>
                        <p class="text-sm text-gray-500 mb-6">Belum ada dokumen yang diupload mahasiswa.</p>
                        @if (request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.documents.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Hapus Filter
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleSelectAll(checkbox) {
                const checkboxes = document.querySelectorAll('.document-checkbox');
                checkboxes.forEach(cb => cb.checked = checkbox.checked);
                updateBulkActions();
            }

            function updateBulkActions() {
                const checkboxes = document.querySelectorAll('.document-checkbox:checked');
                const bulkActions = document.getElementById('bulkActions');
                const selectedCount = document.getElementById('selectedCount');

                if (checkboxes.length > 0) {
                    bulkActions.classList.remove('hidden');
                    selectedCount.textContent = checkboxes.length;
                } else {
                    bulkActions.classList.add('hidden');
                }
            }

            function submitBulkApprove() {
                const checkboxes = document.querySelectorAll('.document-checkbox:checked');
                const ids = Array.from(checkboxes).map(cb => cb.value);

                if (ids.length === 0) {
                    alert('Silakan pilih dokumen terlebih dahulu');
                    return;
                }

                if (!confirm(`Approve ${ids.length} dokumen?`)) {
                    return;
                }

                document.getElementById('bulkDocumentIds').value = JSON.stringify(ids);
                document.getElementById('bulkApproveForm').submit();
            }

            function clearSelection() {
                document.querySelectorAll('.document-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('selectAll').checked = false;
                updateBulkActions();
            }
        </script>
    @endpush
</x-app-layout>

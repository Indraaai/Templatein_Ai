<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pemeriksaan Dokumen AI') }}
            </h2>
            <a href="{{ route('student.documents.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filter & Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('student.documents.index') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari dokumen..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="w-48">
                            <select name="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Semua Status</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Diproses</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal
                                </option>
                            </select>
                        </div>
                        <div class="w-48">
                            <select name="approval_status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Semua Approval</option>
                                <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>
                                    Menunggu</option>
                                <option value="approved"
                                    {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected"
                                    {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="revision"
                                    {{ request('approval_status') == 'revision' ? 'selected' : '' }}>Perlu Revisi
                                </option>
                            </select>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Filter
                        </button>
                        @if (request()->hasAny(['search', 'status', 'approval_status']))
                            <a href="{{ route('student.documents.index') }}"
                                class="px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Documents Grid -->
            @if ($documents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($documents as $document)
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            {{ Str::limit($document->original_filename, 30) }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Template: {{ $document->template->name ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <!-- Status Badge -->
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($document->status == 'completed') bg-green-100 text-green-800
                                        @elseif($document->status == 'processing') bg-yellow-100 text-yellow-800
                                        @elseif($document->status == 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>

                                <!-- AI Score -->
                                @if ($document->ai_score !== null)
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">Skor AI</span>
                                            <span
                                                class="text-sm font-bold {{ $document->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($document->ai_score, 1) }}/100
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full {{ $document->isPassed() ? 'bg-green-600' : 'bg-red-600' }}"
                                                style="width: {{ $document->ai_score }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Approval Status -->
                                <div class="mb-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($document->approval_status == 'approved') bg-green-100 text-green-800
                                        @elseif($document->approval_status == 'rejected') bg-red-100 text-red-800
                                        @elseif($document->approval_status == 'revision') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
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
                                </div>

                                <!-- Timestamps -->
                                <div class="text-xs text-gray-500 space-y-1 mb-4">
                                    <div>Upload: {{ $document->created_at->format('d M Y H:i') }}</div>
                                    @if ($document->ai_checked_at)
                                        <div>AI Check: {{ $document->ai_checked_at->format('d M Y H:i') }}</div>
                                    @endif
                                    @if ($document->checked_at)
                                        <div>Review: {{ $document->checked_at->format('d M Y H:i') }}</div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('student.documents.show', $document) }}"
                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                        Detail
                                    </a>

                                    <a href="{{ route('student.documents.download', $document) }}"
                                        class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>

                                    @if ($document->status == 'completed')
                                        <form action="{{ route('student.documents.recheck', $document) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition"
                                                onclick="return confirm('Periksa ulang dokumen ini?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('student.documents.destroy', $document) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                                            onclick="return confirm('Hapus dokumen ini?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada dokumen</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan mengupload dokumen pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('student.documents.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Upload Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

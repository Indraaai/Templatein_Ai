<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-robot text-blue-600 mr-3"></i>Pemeriksaan Dokumen AI
                </h2>
                <p class="text-gray-600 mt-1 text-sm">Kelola dan periksa dokumen Anda dengan AI</p>
            </div>
            <a href="{{ route('student.documents.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-upload mr-2"></i>
                Upload Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <span class="text-red-800 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Filter & Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
                <div class="p-6">
                    <form method="GET" action="{{ route('student.documents.index') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari dokumen..."
                                class="w-full px-4 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        </div>
                        <div class="w-48">
                            <select name="status"
                                class="w-full px-4 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
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
                                class="w-full px-4 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
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
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        @if (request()->hasAny(['search', 'status', 'approval_status']))
                            <a href="{{ route('student.documents.index') }}"
                                class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200">
                                <i class="fas fa-redo mr-2"></i>Reset
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
                            class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1 pr-3">
                                        <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2">
                                            {{ Str::limit($document->original_filename, 30) }}
                                        </h3>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-file-alt mr-1.5 text-gray-400"></i>
                                            {{ $document->template->name ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <!-- Status Badge -->
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                        @if ($document->status == 'completed') bg-green-100 text-green-800
                                        @elseif($document->status == 'processing') bg-yellow-100 text-yellow-800
                                        @elseif($document->status == 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @if ($document->status == 'completed')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif($document->status == 'processing')
                                            <i class="fas fa-spinner mr-1"></i>
                                        @elseif($document->status == 'failed')
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>

                                <!-- AI Score -->
                                @if ($document->ai_score !== null)
                                    <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-semibold text-gray-700 flex items-center">
                                                <i class="fas fa-robot mr-2 text-blue-500"></i>Skor AI
                                            </span>
                                            <span
                                                class="text-lg font-bold {{ $document->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($document->ai_score, 1) }}/100
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                            <div class="h-3 rounded-full transition-all duration-300 {{ $document->isPassed() ? 'bg-gradient-to-r from-green-500 to-green-600' : 'bg-gradient-to-r from-red-500 to-red-600' }}"
                                                style="width: {{ $document->ai_score }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Approval Status -->
                                <div class="mb-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold w-full justify-center
                                        @if ($document->approval_status == 'approved') bg-green-100 text-green-800
                                        @elseif($document->approval_status == 'rejected') bg-red-100 text-red-800
                                        @elseif($document->approval_status == 'revision') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
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
                                </div>

                                <!-- Timestamps -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-4 space-y-2">
                                    <div class="flex items-center text-xs text-gray-600">
                                        <i class="fas fa-upload w-4 mr-2 text-gray-400"></i>
                                        <span>{{ $document->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @if ($document->ai_checked_at)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <i class="fas fa-robot w-4 mr-2 text-blue-400"></i>
                                            <span>{{ $document->ai_checked_at->format('d M Y H:i') }}</span>
                                        </div>
                                    @endif
                                    @if ($document->checked_at)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <i class="fas fa-user-check w-4 mr-2 text-green-400"></i>
                                            <span>{{ $document->checked_at->format('d M Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('student.documents.show', $document) }}"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                        <i class="fas fa-eye mr-2"></i>Detail
                                    </a>

                                    <a href="{{ route('student.documents.download', $document) }}"
                                        class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all duration-200">
                                        <i class="fas fa-download"></i>
                                    </a>

                                    @if ($document->status == 'completed')
                                        <form action="{{ route('student.documents.recheck', $document) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg font-semibold transition-all duration-200"
                                                onclick="return confirm('Periksa ulang dokumen ini?')">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('student.documents.destroy', $document) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-4 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-semibold transition-all duration-200"
                                            onclick="return confirm('Hapus dokumen ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $documents->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-folder-open text-4xl text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada dokumen</h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">Mulai dengan mengupload dokumen pertama Anda
                            untuk pemeriksaan AI.</p>
                        <div>
                            <a href="{{ route('student.documents.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-upload mr-2"></i>
                                Upload Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

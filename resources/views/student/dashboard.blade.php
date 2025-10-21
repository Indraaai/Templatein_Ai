<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-home text-blue-600 mr-3"></i>Dashboard Mahasiswa
                </h2>
                <p class="text-gray-600 mt-1">Selamat datang kembali, {{ $user->name }}! 👋</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Card with User Info -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 md:p-8 text-white mb-8">
                <div class="flex flex-col lg:flex-row items-center lg:items-center gap-6">
                    <!-- Icon Circle - Centered on mobile, left aligned on desktop -->
                    <div class="flex-shrink-0">
                        <div
                            class="w-28 h-28 md:w-32 md:h-32 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-graduate text-5xl md:text-6xl"></i>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 text-center lg:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">Selamat Datang di TemplateIn AI! 🎓</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center justify-center lg:justify-start mb-2">
                                    <i class="fas fa-building text-xl mr-3"></i>
                                    <span class="text-sm font-medium text-blue-100">Fakultas</span>
                                </div>
                                <p class="font-bold text-lg">{{ $user->faculty->name ?? '-' }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex items-center justify-center lg:justify-start mb-2">
                                    <i class="fas fa-graduation-cap text-xl mr-3"></i>
                                    <span class="text-sm font-medium text-blue-100">Program Studi</span>
                                </div>
                                <p class="font-bold text-lg">{{ $user->programStudy->name ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row flex-wrap gap-3 justify-center lg:justify-start">
                            <a href="{{ route('student.templates.index') }}"
                                class="bg-white text-blue-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center justify-center shadow-md">
                                <i class="fas fa-download mr-2"></i>Download Template
                            </a>
                            <a href="{{ route('student.documents.index') }}"
                                class="bg-blue-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-400 transition inline-flex items-center justify-center">
                                <i class="fas fa-robot mr-2"></i>Cek Dokumen AI
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Available Templates -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Template Tersedia</p>
                                <p class="text-3xl font-bold text-blue-600">{{ $templates->count() }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-file-alt mr-1"></i>Siap diunduh
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-file-alt text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-3">
                        <a href="{{ route('student.templates.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lihat semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Checks -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengecekan</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $recentChecks->count() }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-robot mr-1"></i>Dokumen dicek
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-robot text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-3">
                        <a href="{{ route('student.documents.index') }}"
                            class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            Lihat riwayat <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Success Rate -->
                <div
                    class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Dokumen Selesai</p>
                                <p class="text-3xl font-bold text-green-600">
                                    {{ $recentChecks->where('check_status', 'completed')->count() }}
                                </p>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>Status sukses
                                </p>
                            </div>
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-check-circle text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-6 py-3">
                        <a href="{{ route('student.documents.index') }}"
                            class="text-sm text-green-600 hover:text-green-700 font-medium">
                            Cek dokumen baru <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Templates Available -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-file-alt text-blue-600 mr-2"></i>Template Tersedia
                    </h3>
                    <a href="{{ route('student.templates.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                @if ($templates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($templates->take(3) as $template)
                            <div
                                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100 group">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                            <i class="fas fa-file-word text-blue-600 text-xl"></i>
                                        </div>
                                        <span
                                            class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full">
                                            {{ strtoupper($template->type) }}
                                        </span>
                                    </div>

                                    <h4 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2">{{ $template->name }}
                                    </h4>

                                    @if ($template->description)
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                            {{ Str::limit($template->description, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex gap-2 mt-4">
                                        <a href="{{ route('student.templates.download', $template) }}"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition text-center inline-flex items-center justify-center">
                                            <i class="fas fa-download mr-2"></i>Download
                                        </a>
                                        <a href="{{ route('student.templates.show', $template) }}"
                                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-semibold transition text-center inline-flex items-center justify-center">
                                            <i class="fas fa-eye mr-2"></i>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($templates->count() > 3)
                        <div class="mt-6 text-center">
                            <a href="{{ route('student.templates.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 rounded-lg font-semibold text-sm text-blue-600 hover:bg-blue-50 transition shadow-sm">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Lihat {{ $templates->count() - 3 }} Template Lainnya
                            </a>
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Template</h4>
                        <p class="text-gray-600 mb-6">
                            Belum ada template tersedia untuk fakultas dan program studi Anda.
                        </p>
                        <a href="{{ route('student.templates.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-sync mr-2"></i>Refresh
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recent Checks -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-history text-blue-600 mr-2"></i>Riwayat Pengecekan Terakhir
                    </h3>
                    <a href="{{ route('student.documents.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @if ($recentChecks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-file mr-2"></i>File
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-file-alt mr-2"></i>Template
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-info-circle mr-2"></i>Status
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-star mr-2"></i>Score
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-clock mr-2"></i>Tanggal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recentChecks as $check)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                        <i class="fas fa-file-word text-blue-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">
                                                            {{ Str::limit($check->original_filename, 30) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-600">{{ $check->template->name ?? '-' }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($check->check_status === 'completed')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i>Selesai
                                                    </span>
                                                @elseif($check->check_status === 'pending')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i>Pending
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        <i class="fas fa-times-circle mr-1"></i>Gagal
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($check->compliance_score)
                                                    <div class="flex items-center">
                                                        <span class="text-sm font-bold text-gray-900 mr-2">
                                                            {{ $check->compliance_score }}%
                                                        </span>
                                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                                            <div class="bg-blue-600 h-2 rounded-full"
                                                                style="width: {{ $check->compliance_score }}%"></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                                {{ $check->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-16 text-center">
                            <div
                                class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-chart-bar text-gray-400 text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Riwayat</h4>
                            <p class="text-gray-600 mb-6">
                                Belum ada riwayat pengecekan dokumen. Mulai cek dokumen Anda sekarang!
                            </p>
                            <a href="{{ route('student.documents.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-robot mr-2"></i>Cek Dokumen Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Tips Penggunaan</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                                <span>Download template sesuai kebutuhan Anda dari menu Template</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                                <span>Upload dokumen yang sudah diisi untuk pengecekan otomatis dengan AI</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                                <span>Pantau riwayat pengecekan dan lihat saran perbaikan dari sistem</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Statistik Pemeriksaan Dokumen') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Overview dan analisis dokumen mahasiswa</p>
            </div>
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
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Dokumen</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_documents'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Review</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['pending_review'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['approved'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Mahasiswa</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_students'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Approval Status Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Approval</h3>
                        <div class="space-y-3">
                            @php
                                $total = $stats['total_documents'] ?: 1;
                                $statusData = [
                                    [
                                        'label' => 'Pending',
                                        'count' => $stats['pending_review'],
                                        'color' => 'bg-yellow-500',
                                    ],
                                    ['label' => 'Approved', 'count' => $stats['approved'], 'color' => 'bg-green-500'],
                                    ['label' => 'Rejected', 'count' => $stats['rejected'], 'color' => 'bg-red-500'],
                                    ['label' => 'Revision', 'count' => $stats['revision'], 'color' => 'bg-orange-500'],
                                ];
                            @endphp
                            @foreach ($statusData as $status)
                                @php
                                    $percentage = $total > 0 ? ($status['count'] / $total) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $status['label'] }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $status['count'] }}
                                            ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ $status['color'] }} h-2.5 rounded-full transition-all duration-300"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- AI Score Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Skor AI</h3>
                        <div class="space-y-3">
                            @php
                                $totalChecked = $stats['completed_checks'] ?: 1;
                                $scoreRanges = [
                                    [
                                        'label' => '90-100 (Excellent)',
                                        'count' => $stats['score_90_100'],
                                        'color' => 'bg-green-600',
                                    ],
                                    [
                                        'label' => '80-89 (Good)',
                                        'count' => $stats['score_80_89'],
                                        'color' => 'bg-green-400',
                                    ],
                                    [
                                        'label' => '70-79 (Fair)',
                                        'count' => $stats['score_70_79'],
                                        'color' => 'bg-yellow-500',
                                    ],
                                    [
                                        'label' => '<70 (Need Improvement)',
                                        'count' => $stats['score_below_70'],
                                        'color' => 'bg-red-500',
                                    ],
                                ];
                            @endphp
                            @foreach ($scoreRanges as $range)
                                @php
                                    $percentage = $totalChecked > 0 ? ($range['count'] / $totalChecked) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $range['label'] }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $range['count'] }}
                                            ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ $range['color'] }} h-2.5 rounded-full transition-all duration-300"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Top Students -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Documents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Terbaru</h3>
                        <div class="space-y-3">
                            @forelse($stats['recent_documents'] as $doc)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($doc->original_filename, 30) }}</p>
                                        <p class="text-xs text-gray-500">{{ $doc->user->name }} •
                                            {{ $doc->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if ($doc->ai_score !== null)
                                            <span
                                                class="text-sm font-bold {{ $doc->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($doc->ai_score, 0) }}
                                            </span>
                                        @endif
                                        <a href="{{ route('admin.documents.show', $doc) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            Review →
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada dokumen</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Top Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mahasiswa Aktif</h3>
                        <div class="space-y-3">
                            @forelse($stats['top_students'] as $student)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-gray-700 font-medium text-sm">
                                                {{ substr($student->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">{{ $student->documents_count }}</p>
                                        <p class="text-xs text-gray-500">dokumen</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates Usage -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Penggunaan Template</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Template</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Dokumen</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rata-rata Skor</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pass Rate</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($stats['template_usage'] as $template)
                                    @php
                                        $passRate =
                                            $template->total_checked > 0
                                                ? ($template->passed_count / $template->total_checked) * 100
                                                : 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $template->type }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $template->documents_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($template->avg_score !== null)
                                                <span
                                                    class="text-sm font-medium {{ $template->avg_score >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ number_format($template->avg_score, 1) }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-1">
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-green-600 h-2 rounded-full"
                                                            style="width: {{ $passRate }}%"></div>
                                                    </div>
                                                </div>
                                                <span
                                                    class="ml-2 text-sm text-gray-600">{{ number_format($passRate, 0) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum
                                            ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm text-blue-700">
                            <strong>Info Sistem:</strong> Menggunakan Groq AI (Llama 3.1 70B) untuk analisis dokumen.
                            Data diperbarui secara real-time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

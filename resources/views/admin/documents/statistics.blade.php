<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Statistik Pemeriksaan Dokumen') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Overview dan analisis dokumen mahasiswa
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
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Dokumen</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $stats['total_documents'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl p-3 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Review</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $stats['pending_review'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl p-3 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $stats['approved'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Mahasiswa</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $stats['total_students'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Approval Status Chart -->
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Status Approval
                        </h3>
                        <div class="space-y-4">
                            @php
                                $total = $stats['total_documents'] ?: 1;
                                $statusData = [
                                    [
                                        'label' => 'Pending',
                                        'count' => $stats['pending_review'],
                                        'color' => 'bg-amber-500',
                                        'bgLight' => 'bg-amber-50',
                                        'textColor' => 'text-amber-700',
                                    ],
                                    [
                                        'label' => 'Approved',
                                        'count' => $stats['approved'],
                                        'color' => 'bg-emerald-500',
                                        'bgLight' => 'bg-emerald-50',
                                        'textColor' => 'text-emerald-700',
                                    ],
                                    [
                                        'label' => 'Rejected',
                                        'count' => $stats['rejected'],
                                        'color' => 'bg-rose-500',
                                        'bgLight' => 'bg-rose-50',
                                        'textColor' => 'text-rose-700',
                                    ],
                                    [
                                        'label' => 'Revision',
                                        'count' => $stats['revision'],
                                        'color' => 'bg-orange-500',
                                        'bgLight' => 'bg-orange-50',
                                        'textColor' => 'text-orange-700',
                                    ],
                                ];
                            @endphp
                            @foreach ($statusData as $status)
                                @php
                                    $percentage = $total > 0 ? ($status['count'] / $total) * 100 : 0;
                                @endphp
                                <div class="p-3 {{ $status['bgLight'] }} rounded-lg">
                                    <div class="flex justify-between mb-2">
                                        <span
                                            class="text-sm font-bold {{ $status['textColor'] }}">{{ $status['label'] }}</span>
                                        <span
                                            class="text-sm font-bold {{ $status['textColor'] }}">{{ $status['count'] }}
                                            <span
                                                class="text-xs opacity-75">({{ number_format($percentage, 1) }}%)</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-3 shadow-inner">
                                        <div class="{{ $status['color'] }} h-3 rounded-full transition-all duration-500 shadow"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- AI Score Distribution -->
                <div
                    class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Distribusi Skor AI
                        </h3>
                        <div class="space-y-4">
                            @php
                                $totalChecked = $stats['completed_checks'] ?: 1;
                                $scoreRanges = [
                                    [
                                        'label' => '90-100 (Excellent)',
                                        'count' => $stats['score_90_100'],
                                        'color' => 'bg-emerald-600',
                                        'bgLight' => 'bg-emerald-50',
                                        'textColor' => 'text-emerald-700',
                                    ],
                                    [
                                        'label' => '80-89 (Good)',
                                        'count' => $stats['score_80_89'],
                                        'color' => 'bg-green-500',
                                        'bgLight' => 'bg-green-50',
                                        'textColor' => 'text-green-700',
                                    ],
                                    [
                                        'label' => '70-79 (Fair)',
                                        'count' => $stats['score_70_79'],
                                        'color' => 'bg-amber-500',
                                        'bgLight' => 'bg-amber-50',
                                        'textColor' => 'text-amber-700',
                                    ],
                                    [
                                        'label' => '<70 (Need Improvement)',
                                        'count' => $stats['score_below_70'],
                                        'color' => 'bg-rose-500',
                                        'bgLight' => 'bg-rose-50',
                                        'textColor' => 'text-rose-700',
                                    ],
                                ];
                            @endphp
                            @foreach ($scoreRanges as $range)
                                @php
                                    $percentage = $totalChecked > 0 ? ($range['count'] / $totalChecked) * 100 : 0;
                                @endphp
                                <div class="p-3 {{ $range['bgLight'] }} rounded-lg">
                                    <div class="flex justify-between mb-2">
                                        <span
                                            class="text-sm font-bold {{ $range['textColor'] }}">{{ $range['label'] }}</span>
                                        <span
                                            class="text-sm font-bold {{ $range['textColor'] }}">{{ $range['count'] }}
                                            <span
                                                class="text-xs opacity-75">({{ number_format($percentage, 1) }}%)</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-3 shadow-inner">
                                        <div class="{{ $range['color'] }} h-3 rounded-full transition-all duration-500 shadow"
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
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Dokumen Terbaru
                        </h3>
                        <div class="space-y-2">
                            @forelse($stats['recent_documents'] as $doc)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg hover:shadow-md transition-all duration-200 border border-gray-100">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ Str::limit($doc->original_filename, 30) }}</p>
                                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $doc->user->name }} •
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $doc->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3 ml-4">
                                        @if ($doc->ai_score !== null)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold {{ $doc->isPassed() ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ number_format($doc->ai_score, 0) }}
                                            </span>
                                        @endif
                                        <a href="{{ route('admin.documents.show', $doc) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium">
                                            Review →
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-500 mt-2">Belum ada dokumen</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Top Students -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Mahasiswa Aktif
                        </h3>
                        <div class="space-y-2">
                            @forelse($stats['top_students'] as $student)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border border-gray-100">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <div
                                            class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-sm">
                                                {{ substr($student->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div class="ml-4 min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $student->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-lg font-black text-blue-600">{{ $student->documents_count }}
                                        </p>
                                        <p class="text-xs text-gray-500 font-medium">dokumen</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-sm text-gray-500 mt-2">Belum ada data</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates Usage -->
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Penggunaan Template
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-slate-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Template</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Jumlah Dokumen</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Rata-rata Skor</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Pass Rate</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($stats['template_usage'] as $template)
                                    @php
                                        $passRate =
                                            $template->total_checked > 0
                                                ? ($template->passed_count / $template->total_checked) * 100
                                                : 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $template->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $template->type }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                {{ $template->documents_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($template->avg_score !== null)
                                                <span
                                                    class="text-lg font-black {{ $template->avg_score >= 70 ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ number_format($template->avg_score, 1) }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1 min-w-[100px]">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="h-2.5 rounded-full transition-all duration-500 {{ $passRate >= 70 ? 'bg-emerald-600' : 'bg-rose-600' }}"
                                                            style="width: {{ $passRate }}%"></div>
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-bold {{ $passRate >= 70 ? 'text-emerald-600' : 'text-rose-600' }} min-w-[45px]">{{ number_format($passRate, 0) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-500 mt-2">Belum ada data</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div
                class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-r-xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-bold text-blue-900 mb-1">Info Sistem</h4>
                        <p class="text-sm text-blue-700 leading-relaxed">
                            Menggunakan <span class="font-bold">Groq AI (Llama 3.1 70B)</span> untuk analisis dokumen
                            secara otomatis.
                            Data statistik diperbarui secara real-time dan mencerminkan kondisi terkini dari sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

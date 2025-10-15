<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        👋 Selamat datang, {{ $user->name }}!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        <span class="font-medium">Fakultas:</span> {{ $user->faculty->name ?? '-' }} <br>
                        <span class="font-medium">Program Studi:</span> {{ $user->programStudy->name ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Templates Available -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📄 Template Tersedia</h3>

                @if ($templates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($templates as $template)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $template->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $template->type }}</p>

                                @if ($template->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                        {{ Str::limit($template->description, 100) }}</p>
                                @endif

                                <div class="mt-4 flex gap-2">
                                    <button
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                                        Download
                                    </button>
                                    <button
                                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm transition">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                        <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4">📭</div>
                        <p class="text-gray-600 dark:text-gray-400">
                            Belum ada template tersedia untuk fakultas dan program studi Anda.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Recent Checks -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📊 Riwayat Pengecekan Terakhir
                </h3>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    @if ($recentChecks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            File</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Template</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Score</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($recentChecks as $check)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $check->original_filename }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $check->template->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($check->check_status === 'completed')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                        Selesai
                                                    </span>
                                                @elseif($check->check_status === 'pending')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                        Gagal
                                                    </span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $check->compliance_score ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $check->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4">📊</div>
                            <p class="text-gray-600 dark:text-gray-400">
                                Belum ada riwayat pengecekan dokumen.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

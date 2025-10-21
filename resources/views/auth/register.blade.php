<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - TemplateIn AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .input-focus:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center">
                    <i class="fas fa-file-alt text-blue-600 text-2xl mr-2"></i>
                    <span class="text-2xl font-bold text-gray-800">Template<span class="text-blue-600">In
                            AI</span></span>
                </a>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Sudah punya akun?
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 max-w-6xl w-full gap-8 items-center">

            <!-- Left Side - Illustration -->
            <div class="hidden md:block">
                <div class="gradient-blue rounded-2xl p-12 text-white">
                    <h2 class="text-4xl font-bold mb-6">Bergabunglah dengan Kami!</h2>
                    <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                        Daftar sekarang dan nikmati kemudahan dalam mengelola template dokumen akademik dengan teknologi
                        AI terkini.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bolt text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Proses Cepat & Mudah</p>
                                <p class="text-sm text-blue-100">Daftar dalam hitungan menit</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Aman & Terpercaya</p>
                                <p class="text-sm text-blue-100">Data Anda dilindungi dengan baik</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Fitur Lengkap</p>
                                <p class="text-sm text-blue-100">Akses semua fitur premium</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h1>
                    <p class="text-gray-600">Lengkapi data diri Anda untuk mendaftar</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-blue-600 mr-2"></i>Nama Lengkap
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus autocomplete="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition"
                            placeholder="Nama lengkap Anda">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-blue-600 mr-2"></i>Email
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label for="faculty_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-building text-blue-600 mr-2"></i>Fakultas
                        </label>
                        <select id="faculty_id" name="faculty_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition">
                            <option value="">Pilih Fakultas</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}"
                                    {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Program Studi -->
                    <div>
                        <label for="program_study_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>Program Studi
                        </label>
                        <select id="program_study_id" name="program_study_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition">
                            <option value="">Pilih Program Studi</option>
                        </select>
                        @error('program_study_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-600 mr-2"></i>Password
                        </label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-600 mr-2"></i>Konfirmasi Password
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition"
                            placeholder="Ulangi password Anda">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl mt-6">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Dynamic Program Study loading based on Faculty selection
        document.getElementById('faculty_id').addEventListener('change', async function() {
            const facultyId = this.value;
            const prodiSelect = document.getElementById('program_study_id');

            // Clear existing options
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            prodiSelect.disabled = true;

            if (!facultyId) {
                return;
            }

            // Show loading state
            prodiSelect.innerHTML = '<option value="">Loading...</option>';

            try {
                const response = await fetch(`/api/program-studies/${facultyId}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const programStudies = await response.json();

                // Clear loading state
                prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                prodiSelect.disabled = false;

                if (programStudies.length === 0) {
                    prodiSelect.innerHTML = '<option value="">Tidak ada program studi</option>';
                    return;
                }

                programStudies.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.id;
                    option.textContent = prodi.name;
                    prodiSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading program studies:', error);
                prodiSelect.innerHTML = '<option value="">Error loading data</option>';
                alert('Gagal memuat data program studi. Silakan coba lagi atau refresh halaman.');
            }
        });

        // Restore old program study selection if validation fails
        window.addEventListener('DOMContentLoaded', function() {
            const oldFacultyId = "{{ old('faculty_id') }}";
            const oldProdiId = "{{ old('program_study_id') }}";

            if (oldFacultyId && oldProdiId) {
                // Trigger faculty change to load program studies
                const facultySelect = document.getElementById('faculty_id');
                const event = new Event('change');
                facultySelect.dispatchEvent(event);

                // Set selected program study after a short delay
                setTimeout(() => {
                    document.getElementById('program_study_id').value = oldProdiId;
                }, 500);
            }
        });
    </script>
</body>

</html>

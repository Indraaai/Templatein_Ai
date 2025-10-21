<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TemplateIn AI - Sistem Manajemen Template Dokumen Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-file-alt text-blue-600 text-2xl mr-2"></i>
                        <span class="text-2xl font-bold text-gray-800">Template<span class="text-blue-600">In
                                AI</span></span>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="#features" class="text-gray-700 hover:text-blue-600 font-medium transition">Fitur</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-blue-600 font-medium transition">Cara
                        Kerja</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-blue-600 font-medium transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-20 gradient-blue">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white fade-in">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Kelola Template Dokumen Akademik dengan <span class="text-yellow-300">AI</span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                        Sistem manajemen template dokumen yang memudahkan admin membuat template otomatis dan mahasiswa
                        mengecek kesesuaian dokumen menggunakan teknologi AI terkini.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 px-8 py-4 rounded-lg hover:bg-gray-100 transition font-semibold text-center shadow-lg">
                            Mulai Sekarang
                        </a>
                        <a href="#features"
                            class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-blue-600 transition font-semibold text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <div class="hidden md:block floating">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Auto-Generate Template</p>
                                    <p class="text-sm text-gray-500">Buat file .docx otomatis</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-robot text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">AI Document Checker</p>
                                    <p class="text-sm text-gray-500">Cek dokumen dengan AI</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Analytics Dashboard</p>
                                    <p class="text-sm text-gray-500">Pantau penggunaan real-time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Solusi lengkap untuk manajemen template dokumen akademik</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-magic text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Visual Template Builder</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Buat template dokumen dengan mudah menggunakan visual builder yang intuitif. Drag & drop, atur
                        struktur, dan langsung generate file Word.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-brain text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">AI Document Checker</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Validasi dokumen mahasiswa secara otomatis menggunakan AI. Cek format, struktur, dan kesesuaian
                        dengan template yang telah ditentukan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Live Preview</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Preview template secara real-time sebelum di-generate. Lihat hasil akhir template Anda langsung
                        di browser tanpa perlu download.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-yellow-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Manajemen Mahasiswa</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kelola data mahasiswa berdasarkan fakultas dan program studi. Import data secara bulk dan
                        monitor aktivitas mahasiswa.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-bar text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Dashboard Analytics</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau statistik penggunaan template, aktivitas mahasiswa, dan compliance score dalam dashboard
                        yang informatif.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 card-hover shadow-lg">
                    <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Role-Based Access</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem keamanan berbasis role dengan akses terbatas. Admin dan mahasiswa memiliki dashboard dan
                        fitur yang berbeda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Kerja</h2>
                <p class="text-xl text-gray-600">Mudah digunakan dalam 3 langkah sederhana</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-white text-4xl font-bold">1</span>
                        </div>
                        <div class="hidden md:block absolute top-12 left-1/2 w-full h-0.5 bg-blue-200"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Buat Template</h3>
                    <p class="text-gray-600">
                        Admin membuat template menggunakan Visual Builder atau JSON Editor. Sistem akan auto-generate
                        file .docx
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-white text-4xl font-bold">2</span>
                        </div>
                        <div class="hidden md:block absolute top-12 left-1/2 w-full h-0.5 bg-blue-200"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Download Template</h3>
                    <p class="text-gray-600">
                        Mahasiswa login dan download template sesuai dengan fakultas dan program studi mereka
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div
                        class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-white text-4xl font-bold">3</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Cek dengan AI</h3>
                    <p class="text-gray-600">
                        Upload dokumen yang sudah diisi, AI akan mengecek kesesuaian dan memberikan saran perbaikan
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Mengapa Memilih TemplateIn AI?</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bolt text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Hemat Waktu</h3>
                                <p class="text-gray-600">
                                    Otomasi pembuatan template dan validasi dokumen menghemat waktu admin dan mahasiswa
                                    hingga 70%
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Akurat & Konsisten</h3>
                                <p class="text-gray-600">
                                    AI memastikan semua dokumen mengikuti format dan struktur yang benar tanpa kesalahan
                                    manual
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-cog text-purple-600 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Mudah Digunakan</h3>
                                <p class="text-gray-600">
                                    Interface yang intuitif dan user-friendly membuat siapa saja bisa menggunakan sistem
                                    ini
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 shadow-xl">
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg p-6 shadow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 font-medium">Compliance Score</span>
                                <span class="text-2xl font-bold text-green-600">95%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-600 h-3 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-6 shadow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 font-medium">Processing Speed</span>
                                <span class="text-2xl font-bold text-blue-600">2.5s</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full" style="width: 88%"></div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-6 shadow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 font-medium">User Satisfaction</span>
                                <span class="text-2xl font-bold text-purple-600">4.8/5</span>
                            </div>
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                <i class="fas fa-star-half-alt text-yellow-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Tentang TemplateIn AI</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    TemplateIn AI adalah sistem manajemen template dokumen akademik berbasis web yang menggabungkan
                    kemudahan pembuatan template otomatis dengan kekuatan AI untuk validasi dokumen. Sistem ini
                    dirancang khusus untuk memenuhi kebutuhan institusi pendidikan dalam mengelola dokumen akademik
                    dengan lebih efisien dan akurat.
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 mt-16">
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-2">100+</div>
                    <p class="text-gray-600 font-medium">Template Tersedia</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-2">500+</div>
                    <p class="text-gray-600 font-medium">Dokumen Diproses</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-2">95%</div>
                    <p class="text-gray-600 font-medium">Tingkat Akurasi</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-2">24/7</div>
                    <p class="text-gray-600 font-medium">Layanan Aktif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-blue">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Memulai Perjalanan Anda?
            </h2>
            <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                Bergabunglah dengan ribuan pengguna yang telah merasakan kemudahan mengelola dokumen akademik dengan
                TemplateIn AI
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-600 px-10 py-4 rounded-lg hover:bg-gray-100 transition font-bold text-lg shadow-xl">
                    Daftar Gratis
                </a>
                <a href="{{ route('login') }}"
                    class="border-2 border-white text-white px-10 py-4 rounded-lg hover:bg-white hover:text-blue-600 transition font-bold text-lg">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-file-alt text-blue-400 text-2xl mr-2"></i>
                        <span class="text-2xl font-bold">TemplateIn AI</span>
                    </div>
                    <p class="text-gray-400">
                        Sistem manajemen template dokumen akademik dengan teknologi AI
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Fitur</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Template Builder</a></li>
                        <li><a href="#" class="hover:text-white transition">AI Checker</a></li>
                        <li><a href="#" class="hover:text-white transition">Analytics</a></li>
                        <li><a href="#" class="hover:text-white transition">Live Preview</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Support</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            info@templatein.ai
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            +62 812-3456-7890
                        </li>
                        <li class="flex items-center mt-4 space-x-4">
                            <a href="#" class="text-2xl hover:text-blue-400 transition"><i
                                    class="fab fa-facebook"></i></a>
                            <a href="#" class="text-2xl hover:text-blue-400 transition"><i
                                    class="fab fa-twitter"></i></a>
                            <a href="#" class="text-2xl hover:text-blue-400 transition"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#" class="text-2xl hover:text-blue-400 transition"><i
                                    class="fab fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 TemplateIn AI. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>

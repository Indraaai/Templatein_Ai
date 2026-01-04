/**
 * Template Builder Utilities
 * Helper functions for Template Builder
 */

/**
 * Show alert message
 */
export function showAlert(message, type = 'info', autoClose = true) {
    const container = document.getElementById('alertContainer');
    if (!container) return;

    const colors = {
        success: 'bg-green-50 border-green-500 text-green-800',
        error: 'bg-red-50 border-red-500 text-red-800',
        info: 'bg-blue-50 border-blue-500 text-blue-800',
        warning: 'bg-yellow-50 border-yellow-500 text-yellow-800'
    };

    const icons = {
        success: 'fa-check-circle text-green-500',
        error: 'fa-exclamation-circle text-red-500',
        info: 'fa-info-circle text-blue-500',
        warning: 'fa-exclamation-triangle text-yellow-500'
    };

    const alert = document.createElement('div');
    alert.className = `${colors[type]} border-l-4 rounded-lg p-4 mb-4 flex items-start`;
    alert.innerHTML = `
        <i class="fas ${icons[type]} text-xl mr-3 mt-0.5"></i>
        <div class="flex-1">${message}</div>
        <button onclick="this.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(alert);

    if (autoClose) {
        setTimeout(() => alert.remove(), 5000);
    }
}

/**
 * Get default components configuration
 */
export function getDefaultComponents(type = 'content') {
    if (type === 'cover') {
        return {
            heading: {
                fontSize: 16,
                alignment: 'center',
                bold: true,
                uppercase: true
            },
            subheadings: {},
            content: {
                hasNumbering: false,
                hasIndentation: false,
                allowImages: false,
                allowTables: false
            },
            pageBreakBefore: false
        };
    } else if (type === 'chapter') {
        return {
            heading: {
                fontSize: 14,
                alignment: 'center',
                bold: true,
                uppercase: true
            },
            subheadings: {
                h1: {
                    enabled: true,
                    fontSize: 12,
                    style: 'bold',
                    alignment: 'left'
                },
                h2: {
                    enabled: true,
                    fontSize: 12,
                    style: 'bold',
                    alignment: 'left'
                },
                h3: {
                    enabled: true,
                    fontSize: 12,
                    style: 'normal',
                    alignment: 'left'
                }
            },
            content: {
                hasNumbering: false,
                hasIndentation: true,
                allowImages: true,
                allowTables: true
            },
            pageBreakBefore: true
        };
    }

    // Default content type
    return {
        heading: {
            fontSize: 14,
            alignment: 'center',
            bold: true,
            uppercase: false
        },
        subheadings: {},
        content: {
            hasNumbering: false,
            hasIndentation: true,
            allowImages: false,
            allowTables: false
        },
        pageBreakBefore: false
    };
}

/**
 * Get Skripsi Template
 */
export function getSkripsiTemplate() {
    return {
        formatting: {
            font: {
                name: 'Times New Roman',
                size: 12,
                line_spacing: 1.5
            },
            page_size: 'A4',
            orientation: 'portrait',
            margins: {
                top: 3,
                bottom: 3,
                left: 4,
                right: 3
            }
        },
        sections: [
            {
                title: 'HALAMAN JUDUL',
                description: 'Halaman judul skripsi',
                required: true,
                order: 1,
                components: getDefaultComponents('cover'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'HALAMAN PENGESAHAN',
                description: 'Halaman pengesahan dari pembimbing',
                required: true,
                order: 2,
                components: getDefaultComponents('cover'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'ABSTRAK',
                description: 'Abstrak penelitian dalam bahasa Indonesia',
                required: true,
                order: 3,
                components: {
                    ...getDefaultComponents('content'),
                    pageBreakBefore: true
                },
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'ABSTRACT',
                description: 'Abstrak penelitian dalam bahasa Inggris',
                required: true,
                order: 4,
                components: getDefaultComponents('content'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'KATA PENGANTAR',
                description: 'Kata pengantar dari penulis',
                required: true,
                order: 5,
                components: getDefaultComponents('content'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'DAFTAR ISI',
                description: 'Daftar isi otomatis',
                required: true,
                order: 6,
                components: getDefaultComponents('content'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB I PENDAHULUAN',
                description: 'Bab pendahuluan berisi latar belakang, rumusan masalah, tujuan, dan manfaat',
                required: true,
                order: 7,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB II LANDASAN TEORI',
                description: 'Bab landasan teori dan tinjauan pustaka',
                required: true,
                order: 8,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB III METODOLOGI PENELITIAN',
                description: 'Bab metodologi penelitian',
                required: true,
                order: 9,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB IV HASIL DAN PEMBAHASAN',
                description: 'Bab hasil penelitian dan pembahasan',
                required: true,
                order: 10,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB V PENUTUP',
                description: 'Bab penutup berisi kesimpulan dan saran',
                required: true,
                order: 11,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'DAFTAR PUSTAKA',
                description: 'Daftar referensi yang digunakan',
                required: true,
                order: 12,
                components: getDefaultComponents('content'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'LAMPIRAN',
                description: 'Lampiran pendukung',
                required: false,
                order: 13,
                components: {
                    ...getDefaultComponents('content'),
                    content: {
                        ...getDefaultComponents('content').content,
                        allowImages: true,
                        allowTables: true
                    }
                },
                headingItems: [],
                mainContent: ''
            }
        ]
    };
}

/**
 * Get Proposal Template
 */
export function getProposalTemplate() {
    return {
        formatting: {
            font: {
                name: 'Times New Roman',
                size: 12,
                line_spacing: 1.5
            },
            page_size: 'A4',
            orientation: 'portrait',
            margins: {
                top: 3,
                bottom: 3,
                left: 4,
                right: 3
            }
        },
        sections: [
            {
                title: 'HALAMAN JUDUL',
                description: 'Halaman judul proposal',
                required: true,
                order: 1,
                components: getDefaultComponents('cover'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB I PENDAHULUAN',
                description: 'Bab pendahuluan proposal penelitian',
                required: true,
                order: 2,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB II TINJAUAN PUSTAKA',
                description: 'Bab tinjauan pustaka dan landasan teori',
                required: true,
                order: 3,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'BAB III METODE PENELITIAN',
                description: 'Bab metode penelitian yang akan digunakan',
                required: true,
                order: 4,
                components: getDefaultComponents('chapter'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'DAFTAR PUSTAKA',
                description: 'Daftar referensi yang digunakan',
                required: true,
                order: 5,
                components: getDefaultComponents('content'),
                headingItems: [],
                mainContent: ''
            },
            {
                title: 'JADWAL PENELITIAN',
                description: 'Jadwal pelaksanaan penelitian',
                required: false,
                order: 6,
                components: {
                    ...getDefaultComponents('content'),
                    content: {
                        ...getDefaultComponents('content').content,
                        allowTables: true
                    }
                },
                headingItems: [],
                mainContent: ''
            }
        ]
    };
}

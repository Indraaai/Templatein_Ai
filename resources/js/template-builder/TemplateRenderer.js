/**
 * TemplateRenderer Component
 * Renders template sections and headings in the UI
 */

export class TemplateRenderer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
    }

    /**
     * Render sections list
     */
    renderSections(sections, callbacks = {}) {
        if (!this.container) return;

        if (sections.length === 0) {
            this.container.innerHTML = `
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p class="text-sm">Belum ada bagian yang ditambahkan</p>
                    <p class="text-xs mt-1">Gunakan form di sebelah kiri atau template cepat</p>
                </div>
            `;
            return;
        }

        this.container.innerHTML = sections.map((section, index) => {
            return this.renderSectionCard(section, index, callbacks);
        }).join('');
    }

    /**
     * Render single section card
     */
    renderSectionCard(section, index, callbacks) {
        const components = section.components || {};
        const heading = components.heading || {};
        const content = components.content || {};
        const subheadings = components.subheadings || {};

        // Generate component badges
        const badges = this.generateBadges(heading, content, subheadings);

        // Heading items count
        const headingItemsCount = section.headingItems?.length || 0;

        return `
            <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-all duration-200 cursor-move"
                 data-section-index="${index}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-2 flex-1">
                        <div class="flex flex-col space-y-1 mt-1">
                            <button onclick="${callbacks.moveUp || 'moveUp'}(${index})"
                                class="text-gray-400 hover:text-blue-600 transition"
                                ${index === 0 ? 'disabled' : ''}>
                                <i class="fas fa-chevron-up text-xs"></i>
                            </button>
                            <button onclick="${callbacks.moveDown || 'moveDown'}(${index})"
                                class="text-gray-400 hover:text-blue-600 transition">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <h4 class="font-bold text-gray-900 text-sm">${section.title}</h4>
                                ${section.required ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-700">Wajib</span>' : ''}
                            </div>
                            ${section.description ? `<p class="text-xs text-gray-600 mb-2">${section.description}</p>` : ''}

                            ${badges.length > 0 ? `
                                <div class="flex flex-wrap gap-1 mt-2">
                                    <span class="text-xs text-gray-500"><i class="fas fa-puzzle-piece mr-1"></i></span>
                                    ${badges.join('')}
                                </div>
                            ` : ''}

                            ${headingItemsCount > 0 ? `
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="text-xs text-gray-500"><i class="fas fa-list-ol mr-1"></i></span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-700">
                                        ${headingItemsCount} Heading
                                    </span>
                                </div>
                            ` : ''}

                            ${heading.fontSize || heading.alignment ? `
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-font mr-1"></i>${heading.fontSize || 14}pt • ${this.getAlignmentLabel(heading.alignment)}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    <div class="flex items-center space-x-1 ml-2">
                        <button onclick="${callbacks.edit || 'editSection'}(${index})"
                            class="text-blue-600 hover:text-blue-700 p-1.5 hover:bg-blue-50 rounded transition"
                            title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </button>
                        <button onclick="${callbacks.manageContent || 'manageSectionContent'}(${index})"
                            class="text-purple-600 hover:text-purple-700 p-1.5 hover:bg-purple-50 rounded transition"
                            title="Kelola Konten">
                            <i class="fas fa-file-alt text-xs"></i>
                        </button>
                        <button onclick="${callbacks.duplicate || 'duplicateSection'}(${index})"
                            class="text-green-600 hover:text-green-700 p-1.5 hover:bg-green-50 rounded transition"
                            title="Duplikat">
                            <i class="fas fa-copy text-xs"></i>
                        </button>
                        <button onclick="${callbacks.delete || 'deleteSection'}(${index})"
                            class="text-red-600 hover:text-red-700 p-1.5 hover:bg-red-50 rounded transition"
                            title="Hapus">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Generate component badges
     */
    generateBadges(heading, content, subheadings) {
        const badges = [];

        if (heading.bold) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-gray-700 text-white">Bold</span>');
        }
        if (heading.uppercase) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-gray-600 text-white">UPPER</span>');
        }
        if (subheadings.h1?.enabled) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-700">H1</span>');
        }
        if (subheadings.h2?.enabled) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-700">H2</span>');
        }
        if (subheadings.h3?.enabled) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-700">H3</span>');
        }
        if (content.hasNumbering) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700">Nomor</span>');
        }
        if (content.allowImages) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700">Gambar</span>');
        }
        if (content.allowTables) {
            badges.push('<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">Tabel</span>');
        }

        return badges;
    }

    /**
     * Get alignment label
     */
    getAlignmentLabel(alignment) {
        const labels = {
            'left': 'Kiri',
            'center': 'Tengah',
            'right': 'Kanan',
            'justify': 'Rata'
        };
        return labels[alignment] || 'Tengah';
    }

    /**
     * Update section count display
     */
    updateSectionCount(count) {
        const countElement = document.getElementById('sectionCount');
        if (countElement) {
            countElement.textContent = `${count} Bagian`;
        }
    }

    /**
     * Render heading items in modal
     */
    renderHeadingItems(headingItems, callbacks = {}) {
        if (headingItems.length === 0) {
            return `
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada heading ditambahkan</p>
                </div>
            `;
        }

        const levelColors = {
            'h1': 'bg-blue-100 text-blue-800 border-blue-200',
            'h2': 'bg-green-100 text-green-800 border-green-200',
            'h3': 'bg-purple-100 text-purple-800 border-purple-200'
        };

        const levelLabels = {
            'h1': 'H1',
            'h2': 'H2',
            'h3': 'H3'
        };

        return headingItems.map((item, index) => `
            <div class="bg-white border-2 ${levelColors[item.level]} rounded-lg p-3 hover:shadow-sm transition">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex flex-col space-y-1 mt-1">
                            <button onclick="${callbacks.moveUp || 'moveHeadingUp'}(${index})"
                                class="text-gray-400 hover:text-blue-600 text-xs">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button onclick="${callbacks.moveDown || 'moveHeadingDown'}(${index})"
                                class="text-gray-400 hover:text-blue-600 text-xs">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="px-2 py-1 rounded text-xs font-bold ${levelColors[item.level]}">
                                    ${levelLabels[item.level]}
                                </span>
                                <span class="text-sm font-semibold text-gray-700">${item.title}</span>
                            </div>
                            ${item.content ? `
                                <div class="text-xs text-gray-600 mt-1 pl-2 border-l-2 border-gray-300">
                                    ${item.content.substring(0, 100)}${item.content.length > 100 ? '...' : ''}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="${callbacks.editContent || 'editHeadingContent'}(${index})"
                            class="text-purple-600 hover:text-purple-700 text-sm px-2 py-1"
                            title="Edit Konten">
                            <i class="fas fa-file-alt"></i>
                        </button>
                        <button onclick="${callbacks.edit || 'editHeadingItem'}(${index})"
                            class="text-blue-600 hover:text-blue-700 text-sm px-2 py-1"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="${callbacks.delete || 'deleteHeadingItem'}(${index})"
                            class="text-red-600 hover:text-red-700 text-sm px-2 py-1"
                            title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }
}

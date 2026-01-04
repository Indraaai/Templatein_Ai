/**
 * SectionManager Component
 * Manages sections, headings, and their content
 */

export class SectionManager {
    constructor(contentEditor) {
        this.contentEditor = contentEditor;
        this.sections = [];
        this.currentEditingSection = null;
    }

    /**
     * Add or update section
     */
    saveSection(sectionData) {
        if (sectionData.index !== null && sectionData.index >= 0) {
            // Update existing section
            this.sections[sectionData.index] = {
                ...this.sections[sectionData.index],
                ...sectionData
            };
        } else {
            // Add new section
            sectionData.index = this.sections.length;
            sectionData.order = this.sections.length + 1;
            this.sections.push(sectionData);
        }
    }

    /**
     * Get section by index
     */
    getSection(index) {
        return this.sections[index] || null;
    }

    /**
     * Get all sections
     */
    getAllSections() {
        return this.sections;
    }

    /**
     * Delete section
     */
    deleteSection(index) {
        if (index >= 0 && index < this.sections.length) {
            this.sections.splice(index, 1);
            this.reorderSections();
        }
    }

    /**
     * Duplicate section
     */
    duplicateSection(index) {
        const section = this.getSection(index);
        if (section) {
            const duplicated = JSON.parse(JSON.stringify(section));
            duplicated.title = `${duplicated.title} (Copy)`;
            this.sections.splice(index + 1, 0, duplicated);
            this.reorderSections();
        }
    }

    /**
     * Move section up
     */
    moveUp(index) {
        if (index > 0) {
            [this.sections[index], this.sections[index - 1]] =
            [this.sections[index - 1], this.sections[index]];
            this.reorderSections();
        }
    }

    /**
     * Move section down
     */
    moveDown(index) {
        if (index < this.sections.length - 1) {
            [this.sections[index], this.sections[index + 1]] =
            [this.sections[index + 1], this.sections[index]];
            this.reorderSections();
        }
    }

    /**
     * Reorder sections after changes
     */
    reorderSections() {
        this.sections.forEach((section, index) => {
            section.index = index;
            section.order = index + 1;
        });
    }

    /**
     * Clear all sections
     */
    clearAll() {
        this.sections = [];
    }

    /**
     * Load sections from data
     */
    loadSections(sectionsData) {
        this.sections = sectionsData || [];
    }

    /**
     * Export sections to JSON
     */
    exportToJSON() {
        return JSON.stringify(this.sections, null, 2);
    }

    /**
     * Import sections from JSON
     */
    importFromJSON(jsonString) {
        try {
            this.sections = JSON.parse(jsonString);
            this.reorderSections();
            return true;
        } catch (error) {
            console.error('Failed to import sections:', error);
            return false;
        }
    }

    /**
     * Add heading item to section
     */
    addHeadingItem(sectionIndex, headingData) {
        const section = this.getSection(sectionIndex);
        if (section) {
            if (!section.headingItems) {
                section.headingItems = [];
            }
            section.headingItems.push({
                ...headingData,
                order: section.headingItems.length + 1
            });
        }
    }

    /**
     * Update heading item
     */
    updateHeadingItem(sectionIndex, headingIndex, headingData) {
        const section = this.getSection(sectionIndex);
        if (section && section.headingItems && section.headingItems[headingIndex]) {
            section.headingItems[headingIndex] = {
                ...section.headingItems[headingIndex],
                ...headingData
            };
        }
    }

    /**
     * Delete heading item
     */
    deleteHeadingItem(sectionIndex, headingIndex) {
        const section = this.getSection(sectionIndex);
        if (section && section.headingItems) {
            section.headingItems.splice(headingIndex, 1);
        }
    }

    /**
     * Get heading items for section
     */
    getHeadingItems(sectionIndex) {
        const section = this.getSection(sectionIndex);
        return section?.headingItems || [];
    }

    /**
     * Render all sections to the DOM
     */
    render(containerId = 'sectionsContainer', countId = 'sectionCount') {
        const container = document.getElementById(containerId);
        const countSpan = document.getElementById(countId);

        if (!container) {
            console.error(`Container with id "${containerId}" not found`);
            return;
        }

        // Update count
        if (countSpan) {
            countSpan.textContent = `${this.sections.length} Bagian`;
        }

        // Empty state
        if (this.sections.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p class="text-sm">Belum ada bagian yang ditambahkan</p>
                    <p class="text-xs mt-1">Gunakan form di sebelah kiri atau template cepat</p>
                </div>
            `;
            return;
        }

        // Render sections
        container.innerHTML = this.sections.map((section, index) =>
            this.renderSectionCard(section, index)
        ).join('');
    }

    /**
     * Render a single section card
     */
    renderSectionCard(section, index) {
        const components = section.components || {};
        const heading = components.heading || {};
        const content = components.content || {};
        const subheadings = components.subheadings || {};

        let componentBadges = [];
        if (heading.bold) componentBadges.push('<span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded">Bold</span>');
        if (heading.uppercase) componentBadges.push('<span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded">UPPERCASE</span>');
        if (heading.centered) componentBadges.push('<span class="px-2 py-0.5 bg-pink-100 text-pink-700 text-xs rounded">Center</span>');
        if (heading.numbering) componentBadges.push('<span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">Numbering</span>');

        const contentBadge = content.enabled ?
            '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded"><i class="fas fa-check-circle mr-1"></i>Konten</span>' : '';

        let subheadingBadges = [];
        if (subheadings.h1?.enabled) subheadingBadges.push('<span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded">H1</span>');
        if (subheadings.h2?.enabled) subheadingBadges.push('<span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded">H2</span>');
        if (subheadings.h3?.enabled) subheadingBadges.push('<span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded">H3</span>');

        const headingsCount = section.headings?.length || section.headingItems?.length || 0;
        const headingsBadge = headingsCount > 0 ?
            `<span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded"><i class="fas fa-heading mr-1"></i>${headingsCount} Sub</span>` : '';

        return `
            <div class="section-card bg-white rounded-lg border-2 border-gray-200 hover:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-xs font-bold px-2 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded">
                                    #${index + 1}
                                </span>
                                <h4 class="font-bold text-gray-800 text-lg">${section.title || 'Untitled Section'}</h4>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                ${componentBadges.join('')}
                                ${contentBadge}
                                ${subheadingBadges.join('')}
                                ${headingsBadge}
                            </div>
                        </div>
                        <div class="flex space-x-1 ml-2">
                            <button onclick="window.sectionManager && window.sectionManager.moveUp(${index}); window.sectionManager && window.sectionManager.render()"
                                    ${index === 0 ? 'disabled' : ''}
                                    class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition disabled:opacity-30 disabled:cursor-not-allowed"
                                    title="Pindah ke atas">
                                <i class="fas fa-arrow-up text-sm"></i>
                            </button>
                            <button onclick="window.sectionManager && window.sectionManager.moveDown(${index}); window.sectionManager && window.sectionManager.render()"
                                    ${index === this.sections.length - 1 ? 'disabled' : ''}
                                    class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition disabled:opacity-30 disabled:cursor-not-allowed"
                                    title="Pindah ke bawah">
                                <i class="fas fa-arrow-down text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button onclick="manageSectionContent(${index})"
                            class="flex-1 min-w-[120px] bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 transition text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i>Kelola Konten
                        </button>
                        <button onclick="window.sectionManager && window.sectionManager.duplicateSection(${index}); window.sectionManager && window.sectionManager.render()"
                            class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button onclick="editSection(${index})"
                            class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition text-sm">
                            <i class="fas fa-cog"></i>
                        </button>
                        <button onclick="if(confirm('Hapus section ini?')) { window.sectionManager && window.sectionManager.deleteSection(${index}); window.sectionManager && window.sectionManager.render(); }"
                            class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}

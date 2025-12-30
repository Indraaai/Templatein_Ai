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
}

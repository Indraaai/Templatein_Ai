/**
 * HeadingManager Component
 * Manages heading items and their content within sections
 */

export class HeadingManager {
    constructor(contentEditor) {
        this.contentEditor = contentEditor;
        this.currentSectionIndex = null;
        this.headingItems = [];
    }

    /**
     * Open heading manager for a section
     */
    open(sectionIndex, existingHeadings = []) {
        this.currentSectionIndex = sectionIndex;
        this.headingItems = JSON.parse(JSON.stringify(existingHeadings));
    }

    /**
     * Close heading manager
     */
    close() {
        this.currentSectionIndex = null;
        this.headingItems = [];
    }

    /**
     * Add new heading item
     */
    addHeading(level, title, content = '') {
        this.headingItems.push({
            level: level,
            title: title,
            content: content,
            order: this.headingItems.length + 1,
            id: this.generateId()
        });
    }

    /**
     * Update heading item
     */
    updateHeading(index, data) {
        if (index >= 0 && index < this.headingItems.length) {
            this.headingItems[index] = {
                ...this.headingItems[index],
                ...data
            };
        }
    }

    /**
     * Delete heading item
     */
    deleteHeading(index) {
        if (index >= 0 && index < this.headingItems.length) {
            this.headingItems.splice(index, 1);
            this.reorderHeadings();
        }
    }

    /**
     * Move heading up
     */
    moveHeadingUp(index) {
        if (index > 0) {
            [this.headingItems[index], this.headingItems[index - 1]] =
            [this.headingItems[index - 1], this.headingItems[index]];
            this.reorderHeadings();
        }
    }

    /**
     * Move heading down
     */
    moveHeadingDown(index) {
        if (index < this.headingItems.length - 1) {
            [this.headingItems[index], this.headingItems[index + 1]] =
            [this.headingItems[index + 1], this.headingItems[index]];
            this.reorderHeadings();
        }
    }

    /**
     * Reorder headings
     */
    reorderHeadings() {
        this.headingItems.forEach((item, index) => {
            item.order = index + 1;
        });
    }

    /**
     * Get all heading items
     */
    getHeadings() {
        return this.headingItems;
    }

    /**
     * Get heading by index
     */
    getHeading(index) {
        return this.headingItems[index] || null;
    }

    /**
     * Clear all headings
     */
    clearAll() {
        this.headingItems = [];
    }

    /**
     * Generate unique ID
     */
    generateId() {
        return `heading_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }

    /**
     * Get headings by level
     */
    getHeadingsByLevel(level) {
        return this.headingItems.filter(item => item.level === level);
    }

    /**
     * Count headings by level
     */
    countByLevel(level) {
        return this.getHeadingsByLevel(level).length;
    }

    /**
     * Get statistics
     */
    getStats() {
        return {
            total: this.headingItems.length,
            h1: this.countByLevel('h1'),
            h2: this.countByLevel('h2'),
            h3: this.countByLevel('h3')
        };
    }
}

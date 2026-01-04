/**
 * TemplateBuilder Main Controller
 * Lightweight facade for template builder functionality
 */

import { ContentEditor } from './ContentEditor.js';
import { SectionManager } from './SectionManager.js';
import { HeadingManager } from './HeadingManager.js';

export class TemplateBuilder {
    constructor(config = {}) {
        this.templateId = config.templateId || null;
        this.csrfToken = config.csrfToken || '';
        this.saveUrl = config.saveUrl || '';
        this.redirectUrl = config.redirectUrl || '';
        this.currentRules = config.existingRules || { formatting: {}, sections: [] };

        // Initialize components
        this.contentEditor = new ContentEditor();
        this.sectionManager = new SectionManager(this.contentEditor);
        this.headingManager = new HeadingManager();

        console.log('TemplateBuilder initialized for template:', this.templateId);
    }

    /**
     * Initialize content editors
     */
    initContentEditors() {
        // Main content editor
        if (document.getElementById('mainContentEditor')) {
            this.mainContentEditor = this.contentEditor.initEditor(
                'mainContentEditor',
                'Tulis konten utama section di sini...'
            );
        }

        // Heading content editor
        if (document.getElementById('headingContentEditor')) {
            this.headingContentEditor = this.contentEditor.initEditor(
                'headingContentEditor',
                'Tulis konten heading di sini...'
            );
        }

        return {
            mainContentEditor: this.mainContentEditor,
            headingContentEditor: this.headingContentEditor
        };
    }

    /**
     * Get main content editor HTML
     */
    getMainContent() {
        return this.contentEditor.getContent('mainContentEditor', 'html');
    }

    /**
     * Set main content editor HTML
     */
    setMainContent(html) {
        this.contentEditor.setContent('mainContentEditor', html, 'html');
    }

    /**
     * Get heading content editor HTML
     */
    getHeadingContent() {
        return this.contentEditor.getContent('headingContentEditor', 'html');
    }

    /**
     * Set heading content editor HTML
     */
    setHeadingContent(html) {
        this.contentEditor.setContent('headingContentEditor', html, 'html');
    }

    /**
     * Clear heading content editor
     */
    clearHeadingContent() {
        this.contentEditor.clearContent('headingContentEditor');
    }
}

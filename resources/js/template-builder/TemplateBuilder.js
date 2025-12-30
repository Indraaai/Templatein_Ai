/**
 * TemplateBuilder Main Controller
 * Orchestrates all components and manages the overall builder state
 */

import { ContentEditor } from './ContentEditor.js';
import { SectionManager } from './SectionManager.js';
import { HeadingManager } from './HeadingManager.js';
import { TemplateRenderer } from './TemplateRenderer.js';

export class TemplateBuilder {
    constructor(templateId, existingRules = null) {
        this.templateId = templateId;
        this.currentRules = existingRules || this.getDefaultRules();

        // Initialize components
        this.contentEditor = new ContentEditor();
        this.sectionManager = new SectionManager(this.contentEditor);
        this.headingManager = new HeadingManager(this.contentEditor);
        this.renderer = new TemplateRenderer('sectionsContainer');

        // Load existing data
        if (existingRules && existingRules.sections) {
            this.sectionManager.loadSections(existingRules.sections);
        }

        // Current editing state
        this.editingIndex = null;

        // Initialize
        this.init();
    }

    /**
     * Initialize builder
     */
    init() {
        this.setupEventListeners();
        this.renderSections();
        this.loadFormatting();
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Save button
        document.getElementById('saveTemplateBtn')?.addEventListener('click', () => {
            this.saveTemplate();
        });

        // Preview button
        document.getElementById('previewBtn')?.addEventListener('click', () => {
            this.previewTemplate();
        });

        // Add section button
        document.getElementById('addSectionBtn')?.addEventListener('click', () => {
            this.saveSection();
        });

        // Clear section form button
        document.getElementById('clearFormBtn')?.addEventListener('click', () => {
            this.clearSectionForm();
        });
    }

    /**
     * Get default rules
     */
    getDefaultRules() {
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
            sections: []
        };
    }

    /**
     * Load formatting settings to UI
     */
    loadFormatting() {
        const fmt = this.currentRules.formatting;
        if (!fmt) return;

        document.getElementById('fontName').value = fmt.font.name;
        document.getElementById('fontSize').value = fmt.font.size;
        document.getElementById('lineSpacing').value = fmt.font.line_spacing;
        document.getElementById('pageSize').value = fmt.page_size;
        document.getElementById('orientation').value = fmt.orientation;
        document.getElementById('marginTop').value = fmt.margins.top;
        document.getElementById('marginBottom').value = fmt.margins.bottom;
        document.getElementById('marginLeft').value = fmt.margins.left;
        document.getElementById('marginRight').value = fmt.margins.right;
    }

    /**
     * Get formatting data from UI
     */
    getFormattingData() {
        return {
            font: {
                name: document.getElementById('fontName').value,
                size: parseInt(document.getElementById('fontSize').value),
                line_spacing: parseFloat(document.getElementById('lineSpacing').value)
            },
            page_size: document.getElementById('pageSize').value,
            orientation: document.getElementById('orientation').value,
            margins: {
                top: parseFloat(document.getElementById('marginTop').value),
                bottom: parseFloat(document.getElementById('marginBottom').value),
                left: parseFloat(document.getElementById('marginLeft').value),
                right: parseFloat(document.getElementById('marginRight').value)
            }
        };
    }

    /**
     * Save or update section
     */
    saveSection() {
        const sectionData = this.getSectionData();

        if (!sectionData.title.trim()) {
            this.showAlert('Judul section tidak boleh kosong', 'error');
            return;
        }

        this.sectionManager.saveSection(sectionData);
        this.renderSections();
        this.clearSectionForm();
        this.showAlert('Section berhasil disimpan', 'success');
    }

    /**
     * Get section data from form
     */
    getSectionData() {
        const subheadings = {};

        // Collect H1 settings
        if (document.getElementById('enableH1').checked) {
            subheadings.h1 = {
                enabled: true,
                fontSize: parseInt(document.getElementById('h1FontSize').value),
                style: document.getElementById('h1Style').value,
                alignment: document.getElementById('h1Align').value
            };
        }

        // Collect H2 settings
        if (document.getElementById('enableH2').checked) {
            subheadings.h2 = {
                enabled: true,
                fontSize: parseInt(document.getElementById('h2FontSize').value),
                style: document.getElementById('h2Style').value,
                alignment: document.getElementById('h2Align').value
            };
        }

        // Collect H3 settings
        if (document.getElementById('enableH3').checked) {
            subheadings.h3 = {
                enabled: true,
                fontSize: parseInt(document.getElementById('h3FontSize').value),
                style: document.getElementById('h3Style').value,
                alignment: document.getElementById('h3Align').value
            };
        }

        return {
            index: this.editingIndex,
            title: document.getElementById('sectionTitle').value.trim(),
            description: document.getElementById('sectionDescription').value.trim(),
            required: document.getElementById('isRequired').checked,
            components: {
                heading: {
                    fontSize: parseInt(document.getElementById('headingSize').value),
                    alignment: document.getElementById('headingAlign').value,
                    bold: document.getElementById('headingBold').checked,
                    uppercase: document.getElementById('headingUppercase').checked
                },
                subheadings: subheadings,
                content: {
                    hasNumbering: document.getElementById('hasNumbering').checked,
                    hasIndentation: document.getElementById('hasIndentation').checked,
                    allowImages: document.getElementById('allowImages').checked,
                    allowTables: document.getElementById('allowTables').checked
                },
                pageBreakBefore: document.getElementById('pageBreakBefore').checked
            }
        };
    }

    /**
     * Edit section
     */
    editSection(index) {
        const section = this.sectionManager.getSection(index);
        if (!section) return;

        this.editingIndex = index;
        document.getElementById('editingIndex').value = index;

        // Load section data to form
        document.getElementById('sectionTitle').value = section.title;
        document.getElementById('sectionDescription').value = section.description || '';
        document.getElementById('isRequired').checked = section.required;

        const comp = section.components || {};
        const heading = comp.heading || {};
        const content = comp.content || {};
        const subheadings = comp.subheadings || {};

        // Load heading settings
        document.getElementById('headingSize').value = heading.fontSize || 14;
        document.getElementById('headingAlign').value = heading.alignment || 'center';
        document.getElementById('headingBold').checked = heading.bold || false;
        document.getElementById('headingUppercase').checked = heading.uppercase || false;

        // Load subheading settings
        this.loadSubheadingSettings(subheadings);

        // Load content settings
        document.getElementById('hasNumbering').checked = content.hasNumbering || false;
        document.getElementById('hasIndentation').checked = content.hasIndentation !== false;
        document.getElementById('allowImages').checked = content.allowImages || false;
        document.getElementById('allowTables').checked = content.allowTables || false;
        document.getElementById('pageBreakBefore').checked = comp.pageBreakBefore || false;

        // Scroll to form
        document.getElementById('sectionForm').scrollIntoView({ behavior: 'smooth' });
        this.showAlert('Section dimuat untuk diedit', 'info');
    }

    /**
     * Load subheading settings
     */
    loadSubheadingSettings(subheadings) {
        ['h1', 'h2', 'h3'].forEach(level => {
            const settings = subheadings[level];
            const checkbox = document.getElementById(`enable${level.toUpperCase()}`);
            const panel = document.getElementById(`${level}Settings`);

            if (settings && settings.enabled) {
                checkbox.checked = true;
                panel.style.display = 'grid';
                document.getElementById(`${level}FontSize`).value = settings.fontSize;
                document.getElementById(`${level}Style`).value = settings.style;
                document.getElementById(`${level}Align`).value = settings.alignment;
            } else {
                checkbox.checked = false;
                panel.style.display = 'none';
            }
        });
    }

    /**
     * Clear section form
     */
    clearSectionForm() {
        this.editingIndex = null;
        document.getElementById('editingIndex').value = '';
        document.getElementById('sectionTitle').value = '';
        document.getElementById('sectionDescription').value = '';
        document.getElementById('isRequired').checked = false;

        // Reset to defaults
        document.getElementById('headingSize').value = 14;
        document.getElementById('headingAlign').value = 'center';
        document.getElementById('headingBold').checked = false;
        document.getElementById('headingUppercase').checked = false;

        ['h1', 'h2', 'h3'].forEach(level => {
            document.getElementById(`enable${level.toUpperCase()}`).checked = false;
            document.getElementById(`${level}Settings`).style.display = 'none';
        });

        document.getElementById('hasNumbering').checked = false;
        document.getElementById('hasIndentation').checked = true;
        document.getElementById('allowImages').checked = false;
        document.getElementById('allowTables').checked = false;
        document.getElementById('pageBreakBefore').checked = false;
    }

    /**
     * Delete section
     */
    deleteSection(index) {
        if (confirm('Hapus section ini?')) {
            this.sectionManager.deleteSection(index);
            this.renderSections();
            this.showAlert('Section berhasil dihapus', 'success');
        }
    }

    /**
     * Duplicate section
     */
    duplicateSection(index) {
        this.sectionManager.duplicateSection(index);
        this.renderSections();
        this.showAlert('Section berhasil diduplikasi', 'success');
    }

    /**
     * Render sections
     */
    renderSections() {
        const sections = this.sectionManager.getAllSections();
        this.renderer.renderSections(sections, {
            moveUp: 'window.builder.moveUp',
            moveDown: 'window.builder.moveDown',
            edit: 'window.builder.editSection',
            manageContent: 'window.builder.manageSectionContent',
            duplicate: 'window.builder.duplicateSection',
            delete: 'window.builder.deleteSection'
        });
        this.renderer.updateSectionCount(sections.length);
    }

    /**
     * Move section up
     */
    moveUp(index) {
        this.sectionManager.moveUp(index);
        this.renderSections();
    }

    /**
     * Move section down
     */
    moveDown(index) {
        this.sectionManager.moveDown(index);
        this.renderSections();
    }

    /**
     * Manage section content (open content editor)
     */
    manageSectionContent(index) {
        const section = this.sectionManager.getSection(index);
        if (!section) return;

        // Open content management modal
        window.openContentManager(index, section);
    }

    /**
     * Save template
     */
    async saveTemplate() {
        const formattingData = this.getFormattingData();
        const sections = this.sectionManager.getAllSections();

        const templateRules = {
            formatting: formattingData,
            sections: sections
        };

        const formData = new FormData();
        formData.append('template_rules', JSON.stringify(templateRules));
        formData.append('is_active', document.getElementById('isActive').checked ? '1' : '0');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        try {
            const response = await fetch(`/admin/templates/${this.templateId}/save-builder`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showAlert('Template berhasil disimpan!', 'success');
            } else {
                this.showAlert('Gagal menyimpan template: ' + (data.message || 'Unknown error'), 'error');
            }
        } catch (error) {
            this.showAlert('Terjadi kesalahan: ' + error.message, 'error');
        }
    }

    /**
     * Preview template
     */
    previewTemplate() {
        // Implementation for preview
        window.openPreviewModal();
    }

    /**
     * Show alert message
     */
    showAlert(message, type = 'info') {
        const container = document.getElementById('alertContainer');
        if (!container) return;

        const colors = {
            success: 'bg-green-50 border-green-500 text-green-800',
            error: 'bg-red-50 border-red-500 text-red-800',
            warning: 'bg-yellow-50 border-yellow-500 text-yellow-800',
            info: 'bg-blue-50 border-blue-500 text-blue-800'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
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
        setTimeout(() => alert.remove(), 5000);
    }
}

// Export for global access
window.TemplateBuilder = TemplateBuilder;

/**
 * Template Builder - Main Entry Point
 * This is the main controller that initializes and manages the template builder
 */

import { showAlert, getSkripsiTemplate, getProposalTemplate } from './utils.js';
import * as Extensions from './builder-extensions.js';
import { validateSection, validateTemplate, displayValidationResult } from './validation.js';

class BuilderController {
    constructor(config) {
        this.config = config;
        this.sections = [];
        this.currentEditingIndex = -1;
        this.sortable = null;

        // PHASE 2: Auto-save system
        this.autosaveInterval = null;
        this.lastSavedState = null;
        this.isDirty = false;
        this.draftKey = `builder_draft_${this.config.templateId || 'new'}`;

        // Bind extension methods
        this.openHeadingManager = Extensions.openHeadingManager.bind(this);
        this.closeHeadingManager = Extensions.closeHeadingManager.bind(this);
        this.addNewHeading = Extensions.addNewHeading.bind(this);
        this.closeHeadingInput = Extensions.closeHeadingInput.bind(this);
        this.saveHeadingInput = Extensions.saveHeadingInput.bind(this);
        this.editHeading = Extensions.editHeading.bind(this);
        this.deleteHeading = Extensions.deleteHeading.bind(this);
        this.clearAllHeadings = Extensions.clearAllHeadings.bind(this);
        this.saveHeadings = Extensions.saveHeadings.bind(this);
        this.editHeadingContent = Extensions.editHeadingContent.bind(this);
        this.closeHeadingContentEditor = Extensions.closeHeadingContentEditor.bind(this);
        this.saveHeadingContentEditor = Extensions.saveHeadingContentEditor.bind(this);

        this.openContentManager = Extensions.openContentManager.bind(this);
        this.closeContentManager = Extensions.closeContentManager.bind(this);
        this.switchContentTab = Extensions.switchContentTab.bind(this);
        this.saveContent = Extensions.saveContent.bind(this);

        this.init();
    }

    init() {
        console.log('✅ BuilderController initialized');

        // Load existing sections
        this.loadExistingSections();

        // PHASE 2: Check for draft before proceeding
        this.checkAndLoadDraft();

        // Initialize UI
        this.initializeFormElements();
        this.initializeEventListeners();
        this.initializeSortable();

        // NOTE: Quill editors are initialized on-demand when modals open
        // This fixes the null element issue during page load

        // PHASE 2: Setup auto-save
        this.setupAutosave();
        this.setupBeforeUnloadWarning();

        // Initial render
        this.renderSections();

        // Save initial state
        this.lastSavedState = this.getCurrentState();
    }

    loadExistingSections() {
        const rules = this.config.existingRules;
        if (rules && rules.sections && Array.isArray(rules.sections)) {
            this.sections = rules.sections;
            console.log(`Loaded ${this.sections.length} existing sections`);
        }

        // Load formatting settings
        if (rules && rules.formatting) {
            this.loadFormattingSettings(rules.formatting);
        }
    }

    loadFormattingSettings(formatting) {
        if (formatting.font) {
            document.getElementById('fontName').value = formatting.font.name || 'Times New Roman';
            document.getElementById('fontSize').value = formatting.font.size || 12;
            document.getElementById('lineSpacing').value = formatting.font.line_spacing || 1.5;
        }
        if (formatting.page_size) {
            document.getElementById('pageSize').value = formatting.page_size;
        }
        if (formatting.orientation) {
            document.getElementById('orientation').value = formatting.orientation;
        }
        if (formatting.margins) {
            document.getElementById('marginTop').value = formatting.margins.top || 3;
            document.getElementById('marginBottom').value = formatting.margins.bottom || 3;
            document.getElementById('marginLeft').value = formatting.margins.left || 4;
            document.getElementById('marginRight').value = formatting.margins.right || 3;
        }
    }

    // ============ PHASE 2: AUTO-SAVE SYSTEM ============

    setupAutosave() {
        // Auto-save every 30 seconds
        this.autosaveInterval = setInterval(() => {
            if (this.isDirty) {
                this.saveDraft();
            }
        }, 30000);

        console.log('💾 Auto-save enabled (every 30 seconds)');
    }

    setupBeforeUnloadWarning() {
        window.addEventListener('beforeunload', (e) => {
            if (this.hasUnsavedChanges()) {
                e.preventDefault();
                e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin keluar?';
                // Save draft before leaving
                this.saveDraft();
            }
        });
    }

    saveDraft() {
        try {
            const draft = {
                sections: this.sections,
                formatting: this.buildTemplateRules().formatting,
                timestamp: new Date().toISOString()
            };

            localStorage.setItem(this.draftKey, JSON.stringify(draft));
            this.isDirty = false;
            console.log('💾 Draft saved automatically at', new Date().toLocaleTimeString());

            // Show subtle indicator
            this.showDraftSavedIndicator();
        } catch (error) {
            console.error('Failed to save draft:', error);
            if (error.name === 'QuotaExceededError') {
                showAlert('Storage penuh! Draft tidak bisa disimpan.', 'warning');
            }
        }
    }

    showDraftSavedIndicator() {
        // Create or update draft indicator
        let indicator = document.getElementById('draftIndicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'draftIndicator';
            indicator.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-3 py-1 rounded-lg text-xs shadow-lg transition-opacity duration-300';
            document.body.appendChild(indicator);
        }

        indicator.textContent = '✓ Draft tersimpan';
        indicator.style.opacity = '1';

        // Fade out after 2 seconds
        setTimeout(() => {
            indicator.style.opacity = '0';
        }, 2000);
    }

    checkAndLoadDraft() {
        try {
            const draftStr = localStorage.getItem(this.draftKey);
            if (!draftStr) return;

            const draft = JSON.parse(draftStr);
            const draftTime = new Date(draft.timestamp);
            const minutesAgo = Math.floor((Date.now() - draftTime) / 60000);

            if (confirm(`Ditemukan draft tersimpan (${minutesAgo} menit yang lalu). Muat draft ini?`)) {
                // Load sections
                if (draft.sections && Array.isArray(draft.sections)) {
                    this.sections = draft.sections;
                    console.log(`✅ Draft loaded: ${this.sections.length} sections`);
                }

                // Load formatting
                if (draft.formatting) {
                    this.loadFormattingSettings(draft.formatting);
                }

                showAlert('Draft berhasil dimuat!', 'success');
            } else {
                // User declined, clear the draft
                localStorage.removeItem(this.draftKey);
            }
        } catch (error) {
            console.error('Failed to load draft:', error);
            localStorage.removeItem(this.draftKey);
        }
    }

    getCurrentState() {
        return JSON.stringify({
            sections: this.sections,
            formatting: this.buildTemplateRules().formatting
        });
    }

    hasUnsavedChanges() {
        const currentState = this.getCurrentState();
        return currentState !== this.lastSavedState;
    }

    markDirty() {
        this.isDirty = true;
    }

    initializeFormElements() {
        // Set default values if not already set
        const fontSize = document.getElementById('fontSize');
        if (!fontSize.value) fontSize.value = 12;

        const marginTop = document.getElementById('marginTop');
        if (!marginTop.value) marginTop.value = 3;

        const marginBottom = document.getElementById('marginBottom');
        if (!marginBottom.value) marginBottom.value = 3;

        const marginLeft = document.getElementById('marginLeft');
        if (!marginLeft.value) marginLeft.value = 4;

        const marginRight = document.getElementById('marginRight');
        if (!marginRight.value) marginRight.value = 3;
    }

    initializeEventListeners() {
        // Save button
        document.getElementById('saveButton')?.addEventListener('click', () => this.saveTemplate());

        // Preview button
        document.getElementById('previewButton')?.addEventListener('click', () => this.previewTemplate());

        // Section form
        document.getElementById('saveSectionBtn')?.addEventListener('click', () => this.saveSection());
        document.getElementById('cancelEditBtn')?.addEventListener('click', () => this.cancelEdit());

        // Quick templates
        document.getElementById('loadSkripsiTemplateBtn')?.addEventListener('click', () => this.loadQuickTemplate('skripsi'));
        document.getElementById('loadProposalTemplateBtn')?.addEventListener('click', () => this.loadQuickTemplate('proposal'));
        document.getElementById('loadSkripsiBtn')?.addEventListener('click', () => this.loadQuickTemplate('skripsi'));
        document.getElementById('loadProposalBtn')?.addEventListener('click', () => this.loadQuickTemplate('proposal'));

        // Subheading toggles
        ['h1', 'h2', 'h3'].forEach(level => {
            const checkbox = document.getElementById(`enable${level.toUpperCase()}`);
            if (checkbox) {
                checkbox.addEventListener('change', (e) => {
                    const settings = document.getElementById(`${level}Settings`);
                    if (settings) {
                        settings.classList.toggle('hidden', !e.target.checked);
                    }
                });
            }
        });
    }

    initializeSortable() {
        const container = document.getElementById('sectionsContainer');
        if (container && typeof Sortable !== 'undefined') {
            this.sortable = new Sortable(container, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                handle: '.drag-handle',
                onEnd: (evt) => this.handleSectionReorder(evt)
            });
        }
    }

    handleSectionReorder(evt) {
        const { oldIndex, newIndex } = evt;
        if (oldIndex !== newIndex) {
            const movedSection = this.sections.splice(oldIndex, 1)[0];
            this.sections.splice(newIndex, 0, movedSection);
            this.sections.forEach((section, index) => {
                section.order = index + 1;
            });
            this.renderSections();
            showAlert('Urutan section berhasil diubah', 'success');
        }
    }

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
            title: document.getElementById('sectionTitle').value.trim(),
            description: document.getElementById('sectionDescription').value.trim(),
            required: document.getElementById('sectionRequired').checked,
            components: {
                heading: {
                    fontSize: parseInt(document.getElementById('headingFontSize').value),
                    alignment: document.getElementById('headingAlignment').value,
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
            },
            headingItems: [], // Will be managed separately
            mainContent: '' // Will be managed separately
        };
    }

    saveSection() {
        const sectionData = this.getSectionData();
        const editingIndex = parseInt(document.getElementById('editingIndex').value);

        if (!sectionData.title) {
            showAlert('Judul bagian harus diisi!', 'error');
            return;
        }

        // PHASE 3: Comprehensive validation
        const validation = validateSection(sectionData);
        if (!validation.valid) {
            displayValidationResult(validation, 'Validasi Section');
            return;
        }

        if (editingIndex >= 0) {
            // Update existing section - preserve existing data
            this.sections[editingIndex] = {
                ...this.sections[editingIndex],
                ...sectionData,
                order: editingIndex + 1
            };
            showAlert('Bagian berhasil diupdate!', 'success');
        } else {
            // Add new section
            sectionData.order = this.sections.length + 1;
            this.sections.push(sectionData);
            showAlert('Bagian berhasil ditambahkan!', 'success');
        }

        // Show warnings if any
        if (validation.warnings.length > 0) {
            setTimeout(() => {
                displayValidationResult(validation);
            }, 1500);
        }

        this.markDirty(); // PHASE 2: Mark as dirty
        this.clearSectionForm();
        this.renderSections();
    }

    editSection(index) {
        const section = this.sections[index];
        if (!section) return;

        this.currentEditingIndex = index;
        document.getElementById('editingIndex').value = index;

        // Populate form
        document.getElementById('sectionTitle').value = section.title || '';
        document.getElementById('sectionDescription').value = section.description || '';
        document.getElementById('sectionRequired').checked = section.required || false;

        const components = section.components || {};
        const heading = components.heading || {};
        const subheadings = components.subheadings || {};
        const content = components.content || {};

        // Heading settings
        document.getElementById('headingFontSize').value = heading.fontSize || 14;
        document.getElementById('headingAlignment').value = heading.alignment || 'center';
        document.getElementById('headingBold').checked = heading.bold !== false;
        document.getElementById('headingUppercase').checked = heading.uppercase || false;

        // Subheadings
        ['h1', 'h2', 'h3'].forEach(level => {
            const sub = subheadings[level];
            const enabled = sub && sub.enabled;
            document.getElementById(`enable${level.toUpperCase()}`).checked = enabled;
            const settings = document.getElementById(`${level}Settings`);
            if (settings) {
                settings.classList.toggle('hidden', !enabled);
            }
            if (sub) {
                document.getElementById(`${level}FontSize`).value = sub.fontSize || 12;
                document.getElementById(`${level}Style`).value = sub.style || 'bold';
                document.getElementById(`${level}Align`).value = sub.alignment || 'left';
            }
        });

        // Content settings
        document.getElementById('hasNumbering').checked = content.hasNumbering || false;
        document.getElementById('hasIndentation').checked = content.hasIndentation !== false;
        document.getElementById('allowImages').checked = content.allowImages || false;
        document.getElementById('allowTables').checked = content.allowTables || false;
        document.getElementById('pageBreakBefore').checked = components.pageBreakBefore || false;

        // Update UI
        document.getElementById('formTitle').textContent = 'Edit Bagian';
        document.getElementById('saveSectionBtnText').textContent = 'Update';
        document.getElementById('cancelEditBtn').classList.remove('hidden');

        // Scroll to form
        document.getElementById('sectionTitle').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    deleteSection(index) {
        if (confirm('Hapus section ini?')) {
            this.sections.splice(index, 1);
            this.sections.forEach((section, idx) => {
                section.order = idx + 1;
            });
            this.markDirty(); // PHASE 2: Mark as dirty
            this.renderSections();
            this.clearSectionForm();
            showAlert('Section berhasil dihapus', 'success');
        }
    }

    moveSection(index, direction) {
        const newIndex = direction === 'up' ? index - 1 : index + 1;
        if (newIndex < 0 || newIndex >= this.sections.length) return;

        [this.sections[index], this.sections[newIndex]] = [this.sections[newIndex], this.sections[index]];
        this.sections.forEach((section, idx) => {
            section.order = idx + 1;
        });
        this.markDirty(); // PHASE 2: Mark as dirty
        this.renderSections();
        showAlert('Section berhasil dipindah', 'success');
    }

    duplicateSection(index) {
        const section = this.sections[index];
        if (!section) return;

        const duplicated = JSON.parse(JSON.stringify(section));
        duplicated.title = `${duplicated.title} (Copy)`;
        this.sections.splice(index + 1, 0, duplicated);
        this.sections.forEach((sec, idx) => {
            sec.order = idx + 1;
        });
        this.markDirty(); // PHASE 2: Mark as dirty
        this.renderSections();
        showAlert('Section berhasil diduplikat', 'success');
    }

    cancelEdit() {
        this.clearSectionForm();
    }

    clearSectionForm() {
        document.getElementById('sectionTitle').value = '';
        document.getElementById('sectionDescription').value = '';
        document.getElementById('sectionRequired').checked = false;

        // Reset to defaults
        document.getElementById('headingFontSize').value = '14';
        document.getElementById('headingAlignment').value = 'center';
        document.getElementById('headingBold').checked = true;
        document.getElementById('headingUppercase').checked = false;

        // Reset subheadings
        ['h1', 'h2', 'h3'].forEach(level => {
            document.getElementById(`enable${level.toUpperCase()}`).checked = false;
            const settings = document.getElementById(`${level}Settings`);
            if (settings) settings.classList.add('hidden');
        });

        // Reset content settings
        document.getElementById('hasNumbering').checked = false;
        document.getElementById('hasIndentation').checked = true;
        document.getElementById('allowImages').checked = false;
        document.getElementById('allowTables').checked = false;
        document.getElementById('pageBreakBefore').checked = false;

        document.getElementById('editingIndex').value = '-1';
        document.getElementById('formTitle').textContent = 'Tambah Bagian';
        document.getElementById('saveSectionBtnText').textContent = 'Tambahkan';
        document.getElementById('cancelEditBtn').classList.add('hidden');

        this.currentEditingIndex = -1;
    }

    renderSections() {
        const container = document.getElementById('sectionsContainer');
        const countSpan = document.getElementById('sectionCount');

        countSpan.textContent = `${this.sections.length} Bagian`;

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

        container.innerHTML = this.sections.map((section, index) => {
            return this.renderSectionCard(section, index);
        }).join('');

        // Reattach event listeners
        this.attachSectionEventListeners();
    }

    renderSectionCard(section, index) {
        const components = section.components || {};
        const heading = components.heading || {};
        const content = components.content || {};
        const subheadings = components.subheadings || {};

        // Count heading items and content
        const headingItems = section.headingItems || [];
        const mainContent = section.mainContent || '';
        const headingCount = headingItems.length;
        // FIX: Handle undefined mainContent and filter empty words properly
        const wordCount = mainContent ? mainContent.replace(/<[^>]*>/g, '').split(/\s+/).filter(w => w.trim().length > 0).length : 0;

        let badges = [];
        if (heading.bold) badges.push('<span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Bold</span>');
        if (heading.uppercase) badges.push('<span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">UPPER</span>');

        if (subheadings.h1?.enabled) badges.push('<span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded">H1</span>');
        if (subheadings.h2?.enabled) badges.push('<span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded">H2</span>');
        if (subheadings.h3?.enabled) badges.push('<span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded">H3</span>');

        if (content.hasNumbering) badges.push('<span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Nomor</span>');
        if (content.allowImages) badges.push('<span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">Gambar</span>');
        if (content.allowTables) badges.push('<span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">Tabel</span>');
        if (components.pageBreakBefore) badges.push('<span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">Page Break</span>');

        return `
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200" data-section-index="${index}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex flex-col items-center space-y-1">
                            <button class="section-move-up text-gray-400 hover:text-blue-600 transition" data-index="${index}" ${index === 0 ? 'disabled' : ''}>
                                <i class="fas fa-chevron-up text-xs"></i>
                            </button>
                            <span class="drag-handle w-8 h-8 bg-purple-600 text-white rounded-lg flex items-center justify-center text-xs font-bold cursor-move">
                                ${index + 1}
                            </span>
                            <button class="section-move-down text-gray-400 hover:text-blue-600 transition" data-index="${index}" ${index === this.sections.length - 1 ? 'disabled' : ''}>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">${section.title}</h4>
                                    ${section.description ? `<p class="text-xs text-gray-600 mt-1">${section.description}</p>` : ''}
                                    ${section.required ? '<span class="inline-block mt-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded">Wajib</span>' : ''}
                                </div>
                            </div>
                            ${badges.length > 0 ? `<div class="flex flex-wrap gap-1 mt-2">${badges.join('')}</div>` : ''}

                            <!-- Heading & Content Stats -->
                            <div class="mt-3 pt-3 border-t border-gray-200 flex items-center gap-3">
                                <button class="manage-heading flex items-center gap-1.5 text-xs bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg transition font-medium" data-index="${index}">
                                    <i class="fas fa-list-ol"></i>
                                    <span>Kelola Heading</span>
                                    ${headingCount > 0 ? `<span class="bg-blue-200 text-blue-800 px-1.5 py-0.5 rounded text-xs font-bold ml-1">${headingCount}</span>` : ''}
                                </button>
                                <button class="manage-content flex items-center gap-1.5 text-xs bg-green-50 hover:bg-green-100 text-green-700 px-3 py-1.5 rounded-lg transition font-medium" data-index="${index}">
                                    <i class="fas fa-edit"></i>
                                    <span>Kelola Konten</span>
                                    ${wordCount > 0 ? `<span class="bg-green-200 text-green-800 px-1.5 py-0.5 rounded text-xs font-bold ml-1">${wordCount} kata</span>` : ''}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1 ml-2">
                        <button class="section-edit text-blue-600 hover:bg-blue-50 p-2 rounded transition" data-index="${index}" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <button class="section-duplicate text-green-600 hover:bg-green-50 p-2 rounded transition" data-index="${index}" title="Duplikat">
                            <i class="fas fa-copy text-sm"></i>
                        </button>
                        <button class="section-delete text-red-600 hover:bg-red-50 p-2 rounded transition" data-index="${index}" title="Hapus">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    attachSectionEventListeners() {
        // Edit buttons
        document.querySelectorAll('.section-edit').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.editSection(index);
            });
        });

        // Delete buttons
        document.querySelectorAll('.section-delete').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.deleteSection(index);
            });
        });

        // Duplicate buttons
        document.querySelectorAll('.section-duplicate').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.duplicateSection(index);
            });
        });

        // Move up buttons
        document.querySelectorAll('.section-move-up').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.moveSection(index, 'up');
            });
        });

        // Move down buttons
        document.querySelectorAll('.section-move-down').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.moveSection(index, 'down');
            });
        });

        // Manage Heading buttons
        document.querySelectorAll('.manage-heading').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.openHeadingManager(index);
            });
        });

        // Manage Content buttons
        document.querySelectorAll('.manage-content').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.currentTarget.dataset.index);
                this.openContentManager(index);
            });
        });
    }

    loadQuickTemplate(type) {
        if (this.sections.length > 0) {
            if (!confirm('Template ini akan menimpa sections yang sudah ada. Lanjutkan?')) {
                return;
            }
        }

        const template = type === 'skripsi' ? getSkripsiTemplate() : getProposalTemplate();
        this.sections = template.sections;

        // Load formatting if available
        if (template.formatting) {
            this.loadFormattingSettings(template.formatting);
        }
        this.markDirty(); // PHASE 2: Mark as dirty        this.renderSections();
        showAlert(`Template ${type} berhasil dimuat`, 'success');
    }

    previewTemplate() {
        if (this.sections.length === 0) {
            showAlert('Tidak ada section untuk di-preview', 'warning');
            return;
        }

        const rules = this.buildTemplateRules();

        let preview = `
            <div class="bg-white rounded-lg p-6 max-w-4xl">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Preview Template</h2>

                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h3 class="font-semibold text-gray-700 mb-2">Formatting</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                        <div>Font: ${rules.formatting.font.name} (${rules.formatting.font.size}pt)</div>
                        <div>Line Spacing: ${rules.formatting.font.line_spacing}</div>
                        <div>Page Size: ${rules.formatting.page_size}</div>
                        <div>Orientation: ${rules.formatting.orientation}</div>
                        <div>Margins: T:${rules.formatting.margins.top} B:${rules.formatting.margins.bottom} L:${rules.formatting.margins.left} R:${rules.formatting.margins.right} cm</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold text-gray-700">Sections (${this.sections.length})</h3>
                    ${this.sections.map((s, i) => {
                        // ENHANCEMENT: Show heading items and content in preview
                        const headingItems = s.headingItems || [];
                        const mainContent = s.mainContent || '';
                        const wordCount = mainContent ? mainContent.replace(/<[^>]*>/g, '').split(/\s+/).filter(w => w.trim().length > 0).length : 0;

                        let headingPreview = '';
                        if (headingItems.length > 0) {
                            headingPreview = `
                                <div class="ml-4 mt-2 space-y-1">
                                    <div class="text-xs font-semibold text-gray-600 mb-1">📋 Heading Items:</div>
                                    ${headingItems.map(h => {
                                        const hasContent = h.content && h.content.trim().length > 0;
                                        const indent = h.level === 'h1' ? '' : h.level === 'h2' ? 'ml-4' : 'ml-8';
                                        return `
                                            <div class="text-xs text-gray-600 flex items-center ${indent}">
                                                <span class="inline-block w-16 font-mono">${h.number}</span>
                                                <span class="${h.level === 'h1' ? 'font-semibold' : ''}">${h.title}</span>
                                                ${hasContent ? '<i class="fas fa-check-circle text-green-500 ml-2" title="Ada konten"></i>' : '<i class="fas fa-circle text-gray-300 ml-2" title="Belum ada konten"></i>'}
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            `;
                        }

                        let contentPreview = '';
                        if (wordCount > 0) {
                            contentPreview = `
                                <div class="ml-4 mt-2 text-xs text-gray-600">
                                    📝 Main Content: ${wordCount} words
                                </div>
                            `;
                        }

                        return `
                            <div class="border-l-4 border-purple-600 pl-4 py-2">
                                <div class="font-bold text-gray-800">${i + 1}. ${s.title}</div>
                                ${s.description ? `<div class="text-sm text-gray-600">${s.description}</div>` : ''}
                                ${s.required ? '<span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded">Wajib</span>' : ''}
                                ${headingPreview}
                                ${contentPreview}
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        `;

        showAlert(preview, 'info', false);
    }

    buildTemplateRules() {
        return {
            formatting: {
                font: {
                    name: document.getElementById('fontName').value,
                    size: parseInt(document.getElementById('fontSize').value) || 12,
                    line_spacing: parseFloat(document.getElementById('lineSpacing').value) || 1.5
                },
                page_size: document.getElementById('pageSize').value,
                orientation: document.getElementById('orientation').value,
                margins: {
                    top: parseFloat(document.getElementById('marginTop').value) || 3,
                    bottom: parseFloat(document.getElementById('marginBottom').value) || 3,
                    left: parseFloat(document.getElementById('marginLeft').value) || 4,
                    right: parseFloat(document.getElementById('marginRight').value) || 3
                }
            },
            sections: this.sections
        };
    }

    async saveTemplate() {
        // PHASE 3: Comprehensive template validation
        const rules = this.buildTemplateRules();
        const validation = validateTemplate(this.sections, rules.formatting);

        if (!validation.valid) {
            displayValidationResult(validation, 'Validasi Template');
            return;
        }

        // Show warnings confirmation if any
        if (validation.warnings.length > 0) {
            const warningList = validation.warnings.map(w => `• ${w}`).join('\n');
            const proceed = confirm(
                `Template memiliki beberapa peringatan:\n\n${warningList}\n\nLanjutkan menyimpan?`
            );
            if (!proceed) {
                return;
            }
        }

        const isActive = document.getElementById('isActive').checked;

        // Show loading state
        const saveButton = document.getElementById('saveButton');
        const saveButtonText = document.getElementById('saveButtonText');
        const originalText = saveButtonText.textContent;

        saveButton.disabled = true;
        saveButtonText.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Menyimpan...';

        try {
            const response = await fetch(this.config.saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.config.csrfToken
                },
                body: JSON.stringify({
                    template_rules: JSON.stringify(rules),
                    is_active: isActive
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // PHASE 2: Clear draft and update state
                this.lastSavedState = this.getCurrentState();
                this.isDirty = false;
                localStorage.removeItem(this.draftKey);
                console.log('✅ Draft cleared after successful save');

                showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || this.config.redirectUrl;
                }, 1500);
            } else {
                let errorMessage = data.message || 'Terjadi kesalahan saat menyimpan.';

                if (data.errors && Array.isArray(data.errors)) {
                    errorMessage += '<br><br><strong>Detail error:</strong><ul class="mt-2 ml-4 list-disc">';
                    data.errors.forEach(error => {
                        errorMessage += `<li>${error}</li>`;
                    });
                    errorMessage += '</ul>';
                }

                showAlert(errorMessage, 'error', false);
            }
        } catch (error) {
            console.error('Save error:', error);
            showAlert('Terjadi kesalahan jaringan. Pastikan koneksi internet Anda stabil dan coba lagi.<br><br>Error: ' + error.message, 'error', false);
        } finally {
            // Restore button state
            saveButton.disabled = false;
            saveButtonText.textContent = originalText;
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.builderConfig !== 'undefined') {
        window.builderController = new BuilderController(window.builderConfig);
        console.log('✅ Template Builder ready!');
    } else {
        console.error('❌ Builder config not found');
    }
});

// Make functions available globally for inline onclick handlers (backward compatibility)
window.toggleSubheadingSettings = (level) => {
    const checkbox = document.getElementById(`enable${level.toUpperCase()}`);
    const settings = document.getElementById(`${level}Settings`);
    if (settings) {
        settings.classList.toggle('hidden', !checkbox.checked);
    }
};

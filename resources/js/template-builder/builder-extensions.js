/**
 * Builder Extensions - Heading & Content Management
 * Extension methods for BuilderController
 */

import { showAlert } from './utils.js';
import {
    validateHeading,
    validateHeadingHierarchy,
    canAddHeading,
    displayValidationResult
} from './validation.js';

// Quill editors instances
let mainContentEditorInstance = null;
let headingContentEditorInstance = null;

// Current state
let currentSectionForHeading = null;
let currentHeadingItems = [];
let currentEditingHeadingIndex = null;

/**
 * Initialize Quill Editors (Lazy - called when modal opens)
 * FIX: Initialize on-demand instead of during page load to avoid null elements
 */
export function initializeQuillEditors() {
    // This is now called from openContentManager, not from init()
    initializeQuillEditorsOnDemand();
}

/**
 * Initialize Quill editors on demand (when modal is opened)
 */
function initializeQuillEditorsOnDemand() {
    // Main content editor - only initialize if not already initialized
    if (typeof Quill !== 'undefined' && !mainContentEditorInstance) {
        const editorEl = document.getElementById('mainContentEditor');
        if (editorEl) {
            mainContentEditorInstance = new Quill('#mainContentEditor', {
                theme: 'snow',
                placeholder: 'Tulis konten utama section di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // Word count - FIX: filter empty words
            mainContentEditorInstance.on('text-change', () => {
                const text = mainContentEditorInstance.getText().trim();
                const wordCount = text ? text.split(/\s+/).filter(w => w.trim().length > 0).length : 0;
                const countEl = document.getElementById('mainContentWordCount');
                if (countEl) countEl.textContent = wordCount;
            });
        }
    }

    // Heading content editor - only initialize if not already initialized
    if (typeof Quill !== 'undefined' && !headingContentEditorInstance) {
        const editorEl = document.getElementById('headingContentEditor');
        if (editorEl) {
            headingContentEditorInstance = new Quill('#headingContentEditor', {
                theme: 'snow',
                placeholder: 'Tulis konten heading di sini...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // Word count - FIX: filter empty words
            headingContentEditorInstance.on('text-change', () => {
                const text = headingContentEditorInstance.getText().trim();
                const wordCount = text ? text.split(/\s+/).filter(w => w.trim().length > 0).length : 0;
                const countEl = document.getElementById('headingContentWordCount');
                if (countEl) countEl.textContent = wordCount;
            });
        }
    }
}

// ============ HEADING MANAGEMENT ============

export function openHeadingManager(sectionIndex) {
    const section = this.sections[sectionIndex];
    if (!section) return;

    currentSectionForHeading = sectionIndex;
    currentHeadingItems = section.headingItems || [];

    // Update title
    document.getElementById('headingManagerTitle').textContent = section.title;

    // Render heading items
    renderHeadingItems();

    // Show modal
    const modal = document.getElementById('headingManagerModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}

export function closeHeadingManager() {
    const modal = document.getElementById('headingManagerModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
    currentSectionForHeading = null;
}

export function addNewHeading(level) {
    // VALIDATION: Check heading hierarchy
    if (level === 'h2') {
        const hasH1 = currentHeadingItems.some(h => h.level === 'h1');
        if (!hasH1) {
            showAlert('Tambahkan H1 terlebih dahulu sebelum menambah H2!', 'error');
            return;
        }
    }

    if (level === 'h3') {
        const hasH2 = currentHeadingItems.some(h => h.level === 'h2');
        if (!hasH2) {
            showAlert('Tambahkan H2 terlebih dahulu sebelum menambah H3!', 'error');
            return;
        }
    }

    // VALIDATION: Check max headings
    if (currentHeadingItems.length >= 50) {
        showAlert('Maksimal 50 heading per section!', 'warning');
        return;
    }

    // Auto-generate number based on existing headings
    const suggestedNumber = generateNextHeadingNumber(level);

    // Open input modal
    document.getElementById('headingInputModalTitle').textContent = `Tambah ${level.toUpperCase()}`;
    document.getElementById('headingInputLevel').value = level;
    document.getElementById('headingInputNumber').value = suggestedNumber;
    document.getElementById('headingInputTitle').value = '';
    document.getElementById('headingInputContent').value = '';
    document.getElementById('headingInputIndex').value = '-1';

    const modal = document.getElementById('headingInputModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}

export function closeHeadingInput() {
    const modal = document.getElementById('headingInputModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
}

export function saveHeadingInput() {
    const saveBtn = document.querySelector('#headingInputModal button[onclick*="saveHeadingInput"]');
    const level = document.getElementById('headingInputLevel').value;
    const number = document.getElementById('headingInputNumber').value.trim();
    const title = document.getElementById('headingInputTitle').value.trim();
    const content = document.getElementById('headingInputContent').value.trim();
    const index = parseInt(document.getElementById('headingInputIndex').value);

    // Basic validation
    if (!number || !title) {
        showAlert('Nomor dan judul heading harus diisi!', 'error');
        return;
    }

    const headingData = {
        level: level,
        number: number,
        title: title,
        content: content,
        fullTitle: `${number} ${title}`
    };

    // PHASE 3: Comprehensive validation
    const existingHeadings = index >= 0
        ? currentHeadingItems.filter((_, i) => i !== index)
        : currentHeadingItems;

    const validation = validateHeading(headingData, existingHeadings);

    if (!validation.valid) {
        displayValidationResult(validation, 'Validasi Heading');
        return;
    }

    // Loading state
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    }

    if (index >= 0) {
        // Update existing
        currentHeadingItems[index] = headingData;
        showAlert('Heading berhasil diupdate!', 'success');
    } else {
        // Add new
        currentHeadingItems.push(headingData);
        showAlert('Heading berhasil ditambahkan!', 'success');
    }

    // Show warnings if any
    if (validation.warnings.length > 0) {
        setTimeout(() => {
            displayValidationResult(validation);
        }, 1500);
    }

    // Reset button state
    if (saveBtn) {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan';
    }

    closeHeadingInput();
    renderHeadingItems();
}

export function editHeading(index) {
    const heading = currentHeadingItems[index];
    if (!heading) return;

    document.getElementById('headingInputModalTitle').textContent = `Edit ${heading.level.toUpperCase()}`;
    document.getElementById('headingInputLevel').value = heading.level;
    document.getElementById('headingInputNumber').value = heading.number;
    document.getElementById('headingInputTitle').value = heading.title;
    document.getElementById('headingInputContent').value = heading.content || '';
    document.getElementById('headingInputIndex').value = index;

    const modal = document.getElementById('headingInputModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}

export function deleteHeading(index) {
    if (confirm('Hapus heading ini?')) {
        currentHeadingItems.splice(index, 1);

        // CRITICAL FIX: Recalculate all numbering after delete
        recalculateHeadingNumbers();

        renderHeadingItems();
        showAlert('Heading berhasil dihapus dan numbering diperbarui!', 'success');
    }
}

export function clearAllHeadings() {
    if (confirm('Hapus semua heading?')) {
        currentHeadingItems = [];
        renderHeadingItems();
        showAlert('Semua heading berhasil dihapus!', 'success');
    }
}

export function saveHeadings() {
    const saveBtn = document.querySelector('#headingManagerModal button[onclick*="saveHeadings"]');

    // PHASE 3: Validate heading hierarchy before saving
    const hierarchyValidation = validateHeadingHierarchy(currentHeadingItems);
    if (!hierarchyValidation.valid) {
        displayValidationResult(hierarchyValidation, 'Validasi Struktur Heading');
        return;
    }

    // Loading state
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    }

    if (currentSectionForHeading !== null) {
        this.sections[currentSectionForHeading].headingItems = [...currentHeadingItems];
        this.renderSections();

        // Reset button before closing (will be hidden anyway)
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Semua Heading';
        }

        closeHeadingManager();

        // Show success with warnings if any
        if (hierarchyValidation.warnings.length > 0) {
            showAlert('Heading berhasil disimpan dengan peringatan!', 'success');
            setTimeout(() => {
                displayValidationResult(hierarchyValidation);
            }, 1500);
        } else {
            showAlert('Heading berhasil disimpan!', 'success');
        }
    }
}

function renderHeadingItems() {
    const container = document.getElementById('headingItemsList');
    if (!container) return;

    // Update counts
    const h1Count = currentHeadingItems.filter(h => h.level === 'h1').length;
    const h2Count = currentHeadingItems.filter(h => h.level === 'h2').length;
    const h3Count = currentHeadingItems.filter(h => h.level === 'h3').length;

    document.getElementById('h1Count').textContent = h1Count;
    document.getElementById('h2Count').textContent = h2Count;
    document.getElementById('h3Count').textContent = h3Count;
    document.getElementById('totalHeadingCount').textContent = currentHeadingItems.length;

    if (currentHeadingItems.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p class="text-sm">Belum ada heading yang ditambahkan</p>
                <p class="text-xs mt-1">Klik tombol di atas untuk menambah heading</p>
            </div>
        `;
        return;
    }

    container.innerHTML = currentHeadingItems.map((heading, index) => {
        const levelColors = {
            h1: 'bg-blue-100 text-blue-700 border-blue-300',
            h2: 'bg-green-100 text-green-700 border-green-300',
            h3: 'bg-purple-100 text-purple-700 border-purple-300'
        };
        const levelIcons = {
            h1: 'fa-heading text-blue-600',
            h2: 'fa-heading text-green-600',
            h3: 'fa-heading text-purple-600'
        };

        return `
            <div class="border ${levelColors[heading.level]} rounded-lg p-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 flex-1">
                        <i class="fas ${levelIcons[heading.level]} text-lg mt-1"></i>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-xs font-bold px-2 py-0.5 rounded ${levelColors[heading.level]}">
                                    ${heading.level.toUpperCase()}
                                </span>
                                <span class="font-semibold">${heading.fullTitle}</span>
                            </div>
                            ${heading.content ? `
                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">${heading.content}</p>
                            ` : `
                                <p class="text-xs text-gray-400 italic">Belum ada konten</p>
                            `}
                        </div>
                    </div>
                    <div class="flex items-center space-x-1 ml-2">
                        <button onclick="window.builderController.editHeading(${index})"
                            class="text-blue-600 hover:bg-blue-50 p-2 rounded transition" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <button onclick="window.builderController.editHeadingContent(${index})"
                            class="text-green-600 hover:bg-green-50 p-2 rounded transition" title="Edit Konten">
                            <i class="fas fa-file-edit text-sm"></i>
                        </button>
                        <button onclick="window.builderController.deleteHeading(${index})"
                            class="text-red-600 hover:bg-red-50 p-2 rounded transition" title="Hapus">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

export function editHeadingContent(index) {
    const heading = currentHeadingItems[index];
    if (!heading) return;

    currentEditingHeadingIndex = index;
    document.getElementById('headingContentEditorTitle').textContent = heading.fullTitle;
    document.getElementById('editingHeadingContentIndex').value = index;

    // Load content to editor
    if (headingContentEditorInstance) {
        if (heading.content) {
            headingContentEditorInstance.root.innerHTML = heading.content;
        } else {
            headingContentEditorInstance.setText('');
        }
    }

    const modal = document.getElementById('headingContentEditorModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}

export function closeHeadingContentEditor() {
    const modal = document.getElementById('headingContentEditorModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
    currentEditingHeadingIndex = null;
}

export function saveHeadingContentEditor() {
    const saveBtn = document.querySelector('#headingContentEditorModal button[onclick*="saveHeadingContentEditor"]');
    const index = parseInt(document.getElementById('editingHeadingContentIndex').value);

    // Loading state
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    }

    if (index >= 0 && headingContentEditorInstance) {
        const content = headingContentEditorInstance.root.innerHTML;
        currentHeadingItems[index].content = content;
        renderHeadingItems();

        // Reset button before closing
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Konten';
        }

        closeHeadingContentEditor();
        showAlert('Konten heading berhasil disimpan!', 'success');
    }
}

/**
 * Generate next heading number based on level and existing headings
 */
function generateNextHeadingNumber(level) {
    if (level === 'h1') {
        const h1Count = currentHeadingItems.filter(h => h.level === 'h1').length;
        return `${h1Count + 1}.`;
    } else if (level === 'h2') {
        // Find last H1
        let lastH1Index = -1;
        for (let i = currentHeadingItems.length - 1; i >= 0; i--) {
            if (currentHeadingItems[i].level === 'h1') {
                lastH1Index = i;
                break;
            }
        }

        if (lastH1Index === -1) return '1.1';

        // Count H2 after this H1
        const lastH1Number = currentHeadingItems[lastH1Index].number.replace('.', '');
        let h2Count = 0;
        for (let i = lastH1Index + 1; i < currentHeadingItems.length; i++) {
            if (currentHeadingItems[i].level === 'h1') break;
            if (currentHeadingItems[i].level === 'h2') h2Count++;
        }

        return `${lastH1Number}.${h2Count + 1}`;
    } else if (level === 'h3') {
        // Find last H2
        let lastH2Index = -1;
        for (let i = currentHeadingItems.length - 1; i >= 0; i--) {
            if (currentHeadingItems[i].level === 'h2') {
                lastH2Index = i;
                break;
            }
        }

        if (lastH2Index === -1) return '1.1.1';

        // Count H3 after this H2
        const lastH2Number = currentHeadingItems[lastH2Index].number;
        let h3Count = 0;
        for (let i = lastH2Index + 1; i < currentHeadingItems.length; i++) {
            if (currentHeadingItems[i].level === 'h1' || currentHeadingItems[i].level === 'h2') break;
            if (currentHeadingItems[i].level === 'h3') h3Count++;
        }

        return `${lastH2Number}.${h3Count + 1}`;
    }

    return '1.';
}

/**
 * Recalculate all heading numbers after delete/reorder
 * CRITICAL FIX: Ensures consistent numbering
 */
function recalculateHeadingNumbers() {
    let h1Count = 0;
    let currentH1Number = '';
    let currentH2Number = '';
    let h2CountInH1 = 0;
    let h3CountInH2 = 0;

    currentHeadingItems.forEach((heading) => {
        if (heading.level === 'h1') {
            h1Count++;
            heading.number = `${h1Count}.`;
            currentH1Number = h1Count.toString();
            h2CountInH1 = 0; // Reset H2 counter
            h3CountInH2 = 0; // Reset H3 counter
        } else if (heading.level === 'h2') {
            h2CountInH1++;
            heading.number = `${currentH1Number}.${h2CountInH1}`;
            currentH2Number = heading.number;
            h3CountInH2 = 0; // Reset H3 counter
        } else if (heading.level === 'h3') {
            h3CountInH2++;
            heading.number = `${currentH2Number}.${h3CountInH2}`;
        }

        // Update fullTitle
        heading.fullTitle = `${heading.number} ${heading.title}`;
    });
}

// ============ CONTENT MANAGEMENT ============

export function openContentManager(sectionIndex) {
    const section = this.sections[sectionIndex];
    if (!section) return;

    currentSectionForHeading = sectionIndex;
    currentHeadingItems = section.headingItems || [];

    // Update title
    document.getElementById('contentManagerTitle').textContent = section.title;

    // Show modal first
    const modal = document.getElementById('contentManagerModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    // CRITICAL FIX: Initialize Quill editors AFTER modal is visible
    setTimeout(() => {
        initializeQuillEditorsOnDemand();

        // Load main content after editor is initialized
        if (mainContentEditorInstance) {
            if (section.mainContent) {
                mainContentEditorInstance.root.innerHTML = section.mainContent;
            } else {
                mainContentEditorInstance.setText('');
            }
            // Trigger word count update
            const text = mainContentEditorInstance.getText().trim();
            const wordCount = text ? text.split(/\s+/).filter(w => w.trim().length > 0).length : 0;
            const countEl = document.getElementById('mainContentWordCount');
            if (countEl) countEl.textContent = wordCount;
        }
    }, 100);

    // Update heading content count
    document.getElementById('headingContentCount').textContent = currentHeadingItems.length;

    // Render heading content list
    renderHeadingContentList();

    // Show main content tab by default
    switchContentTab('main');
}

export function closeContentManager() {
    // MEMORY FIX: Clear editor instances to prevent memory leak
    mainContentEditorInstance = null;

    const modal = document.getElementById('contentManagerModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }
    currentSectionForHeading = null;
}

export function switchContentTab(tab) {
    // Update tab buttons
    const mainTab = document.getElementById('mainContentTab');
    const headingTab = document.getElementById('headingContentTab');

    if (tab === 'main') {
        mainTab.classList.add('border-purple-600', 'text-purple-600');
        mainTab.classList.remove('border-transparent', 'text-gray-600');
        headingTab.classList.remove('border-purple-600', 'text-purple-600');
        headingTab.classList.add('border-transparent', 'text-gray-600');

        document.getElementById('mainContentTabContent').classList.remove('hidden');
        document.getElementById('headingContentTabContent').classList.add('hidden');
    } else {
        headingTab.classList.add('border-purple-600', 'text-purple-600');
        headingTab.classList.remove('border-transparent', 'text-gray-600');
        mainTab.classList.remove('border-purple-600', 'text-purple-600');
        mainTab.classList.add('border-transparent', 'text-gray-600');

        document.getElementById('headingContentTabContent').classList.remove('hidden');
        document.getElementById('mainContentTabContent').classList.add('hidden');
    }
}

export function saveContent() {
    const saveBtn = document.querySelector('#contentManagerModal button[onclick*="saveContent"]');

    // Loading state
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    }

    if (currentSectionForHeading !== null) {
        // Save main content
        if (mainContentEditorInstance) {
            this.sections[currentSectionForHeading].mainContent = mainContentEditorInstance.root.innerHTML;
        }

        // Save heading items (in case edited from content manager)
        this.sections[currentSectionForHeading].headingItems = [...currentHeadingItems];

        this.renderSections();

        // Reset button before closing
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Konten';
        }

        closeContentManager();
        showAlert('Konten berhasil disimpan!', 'success');
    }
}

function renderHeadingContentList() {
    const container = document.getElementById('headingContentList');
    if (!container) return;

    if (currentHeadingItems.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-inbox text-3xl mb-2"></i>
                <p class="text-sm">Belum ada heading yang ditambahkan</p>
                <button type="button" onclick="window.builderController.closeContentManager(); window.builderController.openHeadingManager(${currentSectionForHeading});"
                    class="mt-3 text-purple-600 hover:text-purple-700 text-sm font-medium">
                    <i class="fas fa-arrow-right mr-1"></i>Kelola Heading
                </button>
            </div>
        `;
        return;
    }

    container.innerHTML = currentHeadingItems.map((heading, index) => {
        const hasContent = heading.content && heading.content.trim().length > 0;
        const contentSnippet = hasContent
            ? heading.content.replace(/<[^>]*>/g, '').substring(0, 100)
            : 'Belum ada konten';

        return `
            <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-xs font-bold px-2 py-0.5 rounded bg-gray-100">${heading.level.toUpperCase()}</span>
                            <span class="font-semibold text-sm">${heading.fullTitle}</span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2">${contentSnippet}</p>
                    </div>
                    <button onclick="window.builderController.editHeadingContent(${index})"
                        class="ml-2 bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition">
                        ${hasContent ? 'Edit' : 'Tambah'} Konten
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

/**
 * Rules Builder Component
 * Visual drag & drop builder for template rules (replaces JSON textarea)
 */

document.addEventListener('alpine:init', () => {
    Alpine.data('rulesBuilder', () => ({
        // State
        formatting: {
            page_size: 'A4',
            orientation: 'portrait',
            margin: {
                top: 3,
                bottom: 3,
                left: 4,
                right: 3
            },
            font: {
                name: 'Times New Roman',
                size: 12,
                line_spacing: 1.5
            }
        },
        sections: [],

        // Edit modal state
        editingElement: null,
        editingSectionIndex: null,
        editingElementIndex: null,
        showEditModal: false,

        // Add Element Modal state
        showModal: false,
        currentSectionIndex: null,

        // Live Preview state
        zoom: 75,

        // Initialize
        init() {
            // Load from existing JSON if available
            const textarea = document.getElementById('template_rules');
            if (textarea && textarea.value && textarea.value.trim() !== '') {
                try {
                    this.loadFromJSON(textarea.value);
                } catch (e) {
                    console.error('Failed to load existing JSON:', e);
                }
            }

            // Listen for open-element-modal event
            window.addEventListener('open-element-modal', (event) => {
                this.showModal = true;
                this.currentSectionIndex = event.detail.sectionIndex;
            });

            // Update JSON on any change
            this.$watch('formatting', () => this.updateJSON(), { deep: true });
            this.$watch('sections', () => this.updateJSON(), { deep: true });
        },

        // Section Management
        addSection(type = 'chapter') {
            const chapterNumber = type === 'chapter'
                ? this.sections.filter(s => s.type === 'chapter').length + 1
                : null;

            this.sections.push({
                type: type,
                chapter_number: chapterNumber,
                elements: []
            });

            this.updateJSON();
        },

        removeSection(index) {
            if (confirm('Hapus section ini dan semua elemennya?')) {
                this.sections.splice(index, 1);
                this.renumberChapters();
                this.updateJSON();
            }
        },

        deleteSection(index) {
            this.removeSection(index);
        },

        moveSection(fromIndex, toIndex) {
            if (toIndex < 0 || toIndex >= this.sections.length) return;

            const section = this.sections.splice(fromIndex, 1)[0];
            this.sections.splice(toIndex, 0, section);
            this.renumberChapters();
            this.updateJSON();
        },

        renumberChapters() {
            let chapterNum = 1;
            this.sections.forEach(section => {
                if (section.type === 'chapter') {
                    section.chapter_number = chapterNum++;
                }
            });
        },

        // Element Management
        addElement(sectionIndex, type = 'paragraph') {
            const element = this.getDefaultElement(type);
            this.sections[sectionIndex].elements.push(element);
            this.updateJSON();
        },

        getDefaultElement(type) {
            const defaults = {
                heading: {
                    type: 'heading',
                    level: 1,
                    text: 'Heading Text',
                    style: {
                        bold: true,
                        alignment: 'left'
                    }
                },
                paragraph: {
                    type: 'paragraph',
                    text: 'Paragraph text...',
                    style: {
                        alignment: 'justify',
                        indent: 0
                    }
                },
                list: {
                    type: 'list',
                    list_type: 'bullet',
                    items: ['Item 1', 'Item 2'],
                    style: {
                        indent: 1
                    }
                },
                table: {
                    type: 'table',
                    rows: 2,
                    cols: 2,
                    data: [
                        ['Header 1', 'Header 2'],
                        ['Data 1', 'Data 2']
                    ],
                    style: {
                        alignment: 'left'
                    }
                },
                image: {
                    type: 'image',
                    path: 'images/sample.jpg',
                    width: 10,
                    height: 10,
                    style: {
                        alignment: 'center'
                    }
                },
                page_break: {
                    type: 'page_break'
                },
                text_break: {
                    type: 'text_break',
                    count: 1
                },
                line: {
                    type: 'line',
                    width: 100,
                    color: '#000000'
                }
            };

            return defaults[type] || defaults.paragraph;
        },

        removeElement(sectionIndex, elementIndex) {
            if (confirm('Hapus element ini?')) {
                this.sections[sectionIndex].elements.splice(elementIndex, 1);
                this.updateJSON();
            }
        },

        moveElement(sectionIndex, fromIndex, toIndex) {
            if (toIndex < 0 || toIndex >= this.sections[sectionIndex].elements.length) return;

            const element = this.sections[sectionIndex].elements.splice(fromIndex, 1)[0];
            this.sections[sectionIndex].elements.splice(toIndex, 0, element);
            this.updateJSON();
        },

        // Edit Modal
        editElement(sectionIndex, elementIndex) {
            this.editingSectionIndex = sectionIndex;
            this.editingElementIndex = elementIndex;
            this.editingElement = JSON.parse(JSON.stringify(this.sections[sectionIndex].elements[elementIndex]));
            this.showEditModal = true;
        },

        openEditModal(sectionIndex, elementIndex) {
            this.editElement(sectionIndex, elementIndex);
        },

        closeEditModal() {
            this.showEditModal = false;
            this.editingElement = null;
            this.editingSectionIndex = null;
            this.editingElementIndex = null;
        },

        saveEditModal() {
            if (this.editingSectionIndex !== null && this.editingElementIndex !== null) {
                this.sections[this.editingSectionIndex].elements[this.editingElementIndex] =
                    JSON.parse(JSON.stringify(this.editingElement));
                this.updateJSON();
                this.closeEditModal();
            }
        },

        // List Item Management (for list elements)
        addListItem() {
            if (this.editingElement && this.editingElement.type === 'list') {
                this.editingElement.items.push('New item');
            }
        },

        removeListItem(index) {
            if (this.editingElement && this.editingElement.type === 'list') {
                this.editingElement.items.splice(index, 1);
            }
        },

        // Table Management (for table elements)
        addTableRow() {
            if (this.editingElement && this.editingElement.type === 'table') {
                const newRow = new Array(this.editingElement.cols).fill('');
                this.editingElement.data.push(newRow);
                this.editingElement.rows++;
            }
        },

        removeTableRow(index) {
            if (this.editingElement && this.editingElement.type === 'table' && this.editingElement.rows > 1) {
                this.editingElement.data.splice(index, 1);
                this.editingElement.rows--;
            }
        },

        addTableCol() {
            if (this.editingElement && this.editingElement.type === 'table') {
                // Add header
                this.editingElement.headers.push('Column ' + (this.editingElement.headers.length + 1));
                // Add cells to each row
                this.editingElement.data.forEach(row => row.push(''));
                this.editingElement.cols++;
            }
        },

        removeTableCol(index) {
            if (this.editingElement && this.editingElement.type === 'table' && this.editingElement.cols > 1) {
                // Remove header
                this.editingElement.headers.splice(index, 1);
                // Remove cells from each row
                this.editingElement.data.forEach(row => row.splice(index, 1));
                this.editingElement.cols--;
            }
        },

        // JSON Generation
        updateJSON() {
            const json = {
                formatting: this.formatting,
                sections: this.sections
            };

            const textarea = document.getElementById('template_rules');
            if (textarea) {
                textarea.value = JSON.stringify(json, null, 2);
            }
        },

        loadFromJSON(jsonString) {
            try {
                const data = JSON.parse(jsonString);

                if (data.formatting) {
                    this.formatting = { ...this.formatting, ...data.formatting };
                    if (data.formatting.margin) {
                        this.formatting.margin = { ...this.formatting.margin, ...data.formatting.margin };
                    }
                    if (data.formatting.font) {
                        this.formatting.font = { ...this.formatting.font, ...data.formatting.font };
                    }
                }

                if (data.sections && Array.isArray(data.sections)) {
                    this.sections = data.sections;
                }

                this.updateJSON();
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                alert('Invalid JSON format');
            }
        },

        // Utility
        getElementIcon(type) {
            const icons = {
                heading: '📝',
                paragraph: '📄',
                list: '•',
                table: '⊞',
                image: '🖼️',
                page_break: '---',
                text_break: '↵',
                line: '━'
            };
            return icons[type] || '?';
        },

        getElementLabel(element) {
            const labels = {
                heading: `H${element.level || 1}: ${element.text || 'Heading'}`,
                paragraph: element.text ? element.text.substring(0, 30) + '...' : 'Paragraph',
                list: `${element.list_type === 'bullet' ? 'Bullet' : 'Numbered'} List (${element.items?.length || 0} items)`,
                table: `Table (${element.rows}x${element.cols})`,
                image: `Image: ${element.path}`,
                page_break: 'Page Break',
                text_break: `Text Break (${element.count || 1})`,
                line: 'Horizontal Line'
            };
            return labels[element.type] || element.type;
        },

        // Load Sample Rules
        loadSampleRules() {
            if (this.sections.length > 0) {
                if (!confirm('Ini akan mengganti semua section yang ada. Lanjutkan?')) {
                    return;
                }
            }

            const sample = {
                formatting: {
                    page_size: 'A4',
                    orientation: 'portrait',
                    margin: { top: 3, bottom: 3, left: 4, right: 3 },
                    font: { name: 'Times New Roman', size: 12, line_spacing: 1.5 }
                },
                sections: [
                    {
                        type: 'cover',
                        elements: [
                            {
                                type: 'heading',
                                level: 1,
                                text: 'JUDUL SKRIPSI',
                                style: { bold: true, alignment: 'center' }
                            },
                            {
                                type: 'text_break',
                                count: 2
                            },
                            {
                                type: 'paragraph',
                                text: 'Oleh:',
                                style: { alignment: 'center' }
                            },
                            {
                                type: 'paragraph',
                                text: 'NAMA MAHASISWA',
                                style: { alignment: 'center', bold: true }
                            },
                            {
                                type: 'paragraph',
                                text: 'NIM: 1234567890',
                                style: { alignment: 'center' }
                            }
                        ]
                    },
                    {
                        type: 'chapter',
                        chapter_number: 1,
                        elements: [
                            {
                                type: 'heading',
                                level: 1,
                                text: 'BAB I PENDAHULUAN',
                                style: { bold: true, alignment: 'center' }
                            },
                            {
                                type: 'heading',
                                level: 2,
                                text: '1.1 Latar Belakang',
                                style: { bold: true, alignment: 'left' }
                            },
                            {
                                type: 'paragraph',
                                text: 'Isi latar belakang...',
                                style: { alignment: 'justify', indent: 1 }
                            }
                        ]
                    }
                ]
            };

            this.loadFromJSON(JSON.stringify(sample));
        },

        // Live Preview Helper Functions
        getPageWidth() {
            const sizes = {
                'A4': this.formatting.orientation === 'portrait' ? 794 : 1123,
                'Letter': this.formatting.orientation === 'portrait' ? 816 : 1056,
                'Legal': this.formatting.orientation === 'portrait' ? 816 : 1344
            };
            return sizes[this.formatting.page_size] || 794;
        },

        getPageHeight() {
            const sizes = {
                'A4': this.formatting.orientation === 'portrait' ? 1123 : 794,
                'Letter': this.formatting.orientation === 'portrait' ? 1056 : 816,
                'Legal': this.formatting.orientation === 'portrait' ? 1344 : 816
            };
            return sizes[this.formatting.page_size] || 1123;
        }
    }));
});

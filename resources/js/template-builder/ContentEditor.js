/**
 * ContentEditor Component
 * Rich text editor for section content management
 */

export class ContentEditor {
    constructor() {
        this.editors = new Map();
    }

    /**
     * Initialize Quill editor for a specific element
     */
    initEditor(elementId, placeholder = 'Tulis konten di sini...') {
        if (this.editors.has(elementId)) {
            return this.editors.get(elementId);
        }

        const quill = new Quill(`#${elementId}`, {
            theme: 'snow',
            placeholder: placeholder,
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        this.editors.set(elementId, quill);
        return quill;
    }

    /**
     * Get editor instance
     */
    getEditor(elementId) {
        return this.editors.get(elementId);
    }

    /**
     * Get content from editor
     */
    getContent(elementId, format = 'html') {
        const editor = this.editors.get(elementId);
        if (!editor) return '';

        if (format === 'html') {
            return editor.root.innerHTML;
        } else if (format === 'delta') {
            return editor.getContents();
        } else if (format === 'text') {
            return editor.getText();
        }
    }

    /**
     * Set content to editor
     */
    setContent(elementId, content, format = 'html') {
        const editor = this.editors.get(elementId);
        if (!editor) return;

        if (format === 'html') {
            editor.root.innerHTML = content;
        } else if (format === 'delta') {
            editor.setContents(content);
        } else if (format === 'text') {
            editor.setText(content);
        }
    }

    /**
     * Clear editor content
     */
    clearContent(elementId) {
        const editor = this.editors.get(elementId);
        if (editor) {
            editor.setText('');
        }
    }

    /**
     * Destroy editor instance
     */
    destroyEditor(elementId) {
        if (this.editors.has(elementId)) {
            this.editors.delete(elementId);
        }
    }

    /**
     * Get all editors
     */
    getAllEditors() {
        return Array.from(this.editors.entries());
    }
}

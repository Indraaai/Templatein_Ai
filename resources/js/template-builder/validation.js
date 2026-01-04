/**
 * Validation Utilities for Template Builder
 * Provides comprehensive validation for sections, headings, and content
 */

import { showAlert } from './utils.js';

/**
 * Validation result structure
 * @typedef {Object} ValidationResult
 * @property {boolean} valid - Whether validation passed
 * @property {string[]} errors - Array of error messages
 * @property {string[]} warnings - Array of warning messages
 */

/**
 * Validate section data before save
 * @param {Object} section - Section object to validate
 * @returns {ValidationResult}
 */
export function validateSection(section) {
    const errors = [];
    const warnings = [];

    // Required fields
    if (!section.title || section.title.trim() === '') {
        errors.push('Judul section tidak boleh kosong');
    }

    // Title length validation
    if (section.title && section.title.length > 200) {
        errors.push('Judul section maksimal 200 karakter');
    }

    // Description length validation
    if (section.description && section.description.length > 500) {
        errors.push('Deskripsi section maksimal 500 karakter');
    }

    // Rules validation
    if (section.rules && section.rules.length > 1000) {
        warnings.push('Rules section sangat panjang (>1000 karakter)');
    }

    // Content warnings
    if (!section.headingItems || section.headingItems.length === 0) {
        warnings.push('Section belum memiliki heading items');
    }

    if (!section.mainContent || section.mainContent.trim() === '<p><br></p>') {
        warnings.push('Section belum memiliki konten utama');
    }

    return {
        valid: errors.length === 0,
        errors,
        warnings
    };
}

/**
 * Validate heading item data
 * @param {Object} heading - Heading object to validate
 * @param {Array} existingHeadings - Array of existing headings for context
 * @returns {ValidationResult}
 */
export function validateHeading(heading, existingHeadings = []) {
    const errors = [];
    const warnings = [];

    // Required fields
    if (!heading.number || heading.number.trim() === '') {
        errors.push('Nomor heading tidak boleh kosong');
    }

    if (!heading.title || heading.title.trim() === '') {
        errors.push('Judul heading tidak boleh kosong');
    }

    // Number format validation
    if (heading.number) {
        const numberPattern = /^\d+(\.\d+)*\.?$/;
        if (!numberPattern.test(heading.number)) {
            errors.push(`Format nomor tidak valid: "${heading.number}". Gunakan format: 1., 1.1, atau 1.1.1`);
        }
    }

    // Title length validation
    if (heading.title && heading.title.length > 200) {
        errors.push('Judul heading maksimal 200 karakter');
    }

    // Content length warning
    if (heading.content && heading.content.length > 5000) {
        warnings.push('Konten heading sangat panjang (>5000 karakter)');
    }

    // Duplicate number check
    const duplicate = existingHeadings.find(
        h => h !== heading && h.number === heading.number
    );
    if (duplicate) {
        errors.push(`Nomor heading "${heading.number}" sudah digunakan`);
    }

    return {
        valid: errors.length === 0,
        errors,
        warnings
    };
}

/**
 * Validate heading hierarchy (H2 requires H1, H3 requires H2)
 * @param {Array} headings - Array of all headings
 * @returns {ValidationResult}
 */
export function validateHeadingHierarchy(headings) {
    const errors = [];
    const warnings = [];

    if (!headings || headings.length === 0) {
        return { valid: true, errors, warnings };
    }

    const hasH1 = headings.some(h => h.level === 'h1');
    const hasH2 = headings.some(h => h.level === 'h2');
    const hasH3 = headings.some(h => h.level === 'h3');

    // H2 requires at least one H1
    if (hasH2 && !hasH1) {
        errors.push('Heading H2 memerlukan heading H1 terlebih dahulu');
    }

    // H3 requires at least one H2
    if (hasH3 && !hasH2) {
        errors.push('Heading H3 memerlukan heading H2 terlebih dahulu');
    }

    // Check sequential hierarchy
    let lastH1Index = -1;
    let lastH2Index = -1;

    headings.forEach((heading, index) => {
        if (heading.level === 'h1') {
            lastH1Index = index;
        } else if (heading.level === 'h2') {
            if (lastH1Index === -1) {
                errors.push(`H2 "${heading.title}" muncul sebelum H1 pertama`);
            }
            lastH2Index = index;
        } else if (heading.level === 'h3') {
            if (lastH2Index === -1) {
                errors.push(`H3 "${heading.title}" muncul sebelum H2 pertama`);
            }
        }
    });

    return {
        valid: errors.length === 0,
        errors,
        warnings
    };
}

/**
 * Validate heading numbering sequence
 * @param {Array} headings - Array of all headings
 * @returns {ValidationResult}
 */
export function validateHeadingNumbering(headings) {
    const errors = [];
    const warnings = [];

    if (!headings || headings.length === 0) {
        return { valid: true, errors, warnings };
    }

    let expectedH1 = 1;
    let expectedH2 = {};
    let expectedH3 = {};

    headings.forEach((heading, index) => {
        const number = heading.number.replace(/\.$/, ''); // Remove trailing dot

        if (heading.level === 'h1') {
            const expected = `${expectedH1}`;
            if (number !== expected) {
                warnings.push(`H1 #${index + 1}: Expected "${expected}." but found "${heading.number}"`);
            }
            expectedH1++;
            expectedH2[expectedH1 - 1] = 1; // Reset H2 counter for this H1
        } else if (heading.level === 'h2') {
            const parts = number.split('.');
            if (parts.length !== 2) {
                errors.push(`H2 numbering invalid: "${heading.number}". Expected format: X.Y`);
            } else {
                const h1Num = parseInt(parts[0]);
                const h2Num = parseInt(parts[1]);

                if (!expectedH2[h1Num]) {
                    warnings.push(`H2 "${heading.number}" references non-existent H1`);
                } else {
                    const expected = `${h1Num}.${expectedH2[h1Num]}`;
                    if (number !== expected) {
                        warnings.push(`H2 #${index + 1}: Expected "${expected}." but found "${heading.number}"`);
                    }
                    expectedH2[h1Num]++;
                    expectedH3[number] = 1; // Reset H3 counter
                }
            }
        } else if (heading.level === 'h3') {
            const parts = number.split('.');
            if (parts.length !== 3) {
                errors.push(`H3 numbering invalid: "${heading.number}". Expected format: X.Y.Z`);
            }
        }
    });

    return {
        valid: errors.length === 0,
        errors,
        warnings
    };
}

/**
 * Validate template before save
 * @param {Array} sections - Array of all sections
 * @param {Object} formatting - Formatting configuration
 * @returns {ValidationResult}
 */
export function validateTemplate(sections, formatting) {
    const errors = [];
    const warnings = [];

    // Must have at least one section
    if (!sections || sections.length === 0) {
        errors.push('Template harus memiliki minimal 1 section');
        return { valid: false, errors, warnings };
    }

    // Validate each section
    sections.forEach((section, index) => {
        const sectionValidation = validateSection(section);

        if (!sectionValidation.valid) {
            errors.push(`Section #${index + 1} (${section.title}): ${sectionValidation.errors.join(', ')}`);
        }

        sectionValidation.warnings.forEach(warning => {
            warnings.push(`Section #${index + 1} (${section.title}): ${warning}`);
        });

        // Validate headings in this section
        if (section.headingItems && section.headingItems.length > 0) {
            const hierarchyValidation = validateHeadingHierarchy(section.headingItems);
            if (!hierarchyValidation.valid) {
                errors.push(`Section #${index + 1} heading hierarchy: ${hierarchyValidation.errors.join(', ')}`);
            }

            const numberingValidation = validateHeadingNumbering(section.headingItems);
            numberingValidation.warnings.forEach(warning => {
                warnings.push(`Section #${index + 1}: ${warning}`);
            });
        }
    });

    // Formatting validation
    if (formatting) {
        if (formatting.fontSize && (formatting.fontSize < 8 || formatting.fontSize > 24)) {
            warnings.push('Ukuran font tidak umum (di luar range 8-24pt)');
        }
    }

    // Check for empty template
    const hasContent = sections.some(s =>
        (s.headingItems && s.headingItems.length > 0) ||
        (s.mainContent && s.mainContent.trim() !== '<p><br></p>')
    );

    if (!hasContent) {
        warnings.push('Template tidak memiliki konten (semua section kosong)');
    }

    return {
        valid: errors.length === 0,
        errors,
        warnings
    };
}

/**
 * Display validation result to user
 * @param {ValidationResult} result - Validation result
 * @param {string} context - Context message (e.g., "Saving section")
 */
export function displayValidationResult(result, context = '') {
    if (result.errors.length > 0) {
        const errorHtml = `
            <div class="mb-2"><strong>${context ? context + ': ' : ''}Validation Error</strong></div>
            <ul class="list-disc list-inside">
                ${result.errors.map(err => `<li>${err}</li>`).join('')}
            </ul>
        `;
        showAlert(errorHtml, 'error', false);
        return false;
    }

    if (result.warnings.length > 0) {
        const warningHtml = `
            <div class="mb-2"><strong>${context ? context + ': ' : ''}Peringatan</strong></div>
            <ul class="list-disc list-inside">
                ${result.warnings.map(warn => `<li>${warn}</li>`).join('')}
            </ul>
        `;
        showAlert(warningHtml, 'warning', false);
    }

    return true;
}

/**
 * Check if heading can be added based on hierarchy
 * @param {string} level - Heading level (h1, h2, h3)
 * @param {Array} existingHeadings - Existing headings array
 * @returns {boolean}
 */
export function canAddHeading(level, existingHeadings) {
    if (level === 'h1') return true;

    if (level === 'h2') {
        return existingHeadings.some(h => h.level === 'h1');
    }

    if (level === 'h3') {
        return existingHeadings.some(h => h.level === 'h2');
    }

    return false;
}

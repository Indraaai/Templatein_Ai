<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * TemplateRulesParser
 *
 * Converts Template Builder frontend output structure to PhpWord-compatible format
 * Handles transformation from component-based structure to element-based structure
 */
class TemplateRulesParser
{
    /**
     * Parse template rules from frontend format to generator format
     *
     * @param array $rules Frontend template rules
     * @return array Parsed rules ready for document generation
     */
    public function parse(array $rules): array
    {
        return [
            'formatting' => $this->parseFormatting($rules['formatting'] ?? []),
            'sections' => $this->parseSections($rules['sections'] ?? []),
        ];
    }

    /**
     * Parse formatting settings
     */
    protected function parseFormatting(array $formatting): array
    {
        return [
            'page_size' => $formatting['page_size'] ?? 'A4',
            'orientation' => $formatting['orientation'] ?? 'portrait',
            'margins' => [
                'top' => $formatting['margins']['top'] ?? 3,
                'bottom' => $formatting['margins']['bottom'] ?? 3,
                'left' => $formatting['margins']['left'] ?? 4,
                'right' => $formatting['margins']['right'] ?? 3,
            ],
            'font' => [
                'name' => $formatting['font']['name'] ?? 'Times New Roman',
                'size' => $formatting['font']['size'] ?? 12,
                'line_spacing' => $formatting['font']['line_spacing'] ?? 1.5,
            ],
        ];
    }

    /**
     * Parse sections from component-based to element-based structure
     */
    protected function parseSections(array $sections): array
    {
        $parsedSections = [];

        foreach ($sections as $section) {
            $parsedSections[] = $this->parseSection($section);
        }

        return $parsedSections;
    }

    /**
     * Parse single section
     */
    protected function parseSection(array $section): array
    {
        $elements = [];

        // Add page break if needed
        if (($section['components']['pageBreakBefore'] ?? false) && count($elements) > 0) {
            $elements[] = ['type' => 'page_break'];
        }

        // Add section heading
        if (!empty($section['title'])) {
            $elements[] = $this->createHeadingElement(
                $section['title'],
                $section['components']['heading'] ?? []
            );
        }

        // Add section main content
        if (!empty($section['mainContent'])) {
            $elements[] = [
                'type' => 'html_content',
                'html' => $section['mainContent'],
            ];
        }

        // Add heading items with their content
        if (!empty($section['headingItems'])) {
            foreach ($section['headingItems'] as $headingItem) {
                $elements = array_merge($elements, $this->parseHeadingItem($headingItem, $section));
            }
        }

        return [
            'title' => $section['title'] ?? '',
            'description' => $section['description'] ?? '',
            'required' => $section['required'] ?? false,
            'formatting' => $this->getSectionFormatting($section),
            'elements' => $elements,
        ];
    }

    /**
     * Parse heading item and its content
     */
    protected function parseHeadingItem(array $headingItem, array $parentSection): array
    {
        $elements = [];

        // Get subheading settings
        $subheadings = $parentSection['components']['subheadings'] ?? [];
        $level = $headingItem['level'] ?? 'h1'; // h1, h2, h3
        $headingConfig = $subheadings[$level] ?? [];

        // Add heading title with number
        if (!empty($headingItem['title'])) {
            // Combine number and title (e.g., "1.1 Introduction")
            $number = $headingItem['number'] ?? '';
            $title = $headingItem['title'] ?? '';
            $fullTitle = trim($number) . ' ' . trim($title);

            $elements[] = [
                'type' => 'heading',
                'level' => $this->getLevelNumber($level),
                'text' => $fullTitle,
                'style' => [
                    'font_name' => 'Times New Roman',
                    'font_size' => $headingConfig['fontSize'] ?? 12,
                    'bold' => ($headingConfig['style'] ?? 'bold') === 'bold',
                    'alignment' => $headingConfig['alignment'] ?? 'left',
                ],
            ];
        }

        // Add heading content (HTML)
        if (!empty($headingItem['content'])) {
            $elements[] = [
                'type' => 'html_content',
                'html' => $headingItem['content'],
            ];
        }

        return $elements;
    }

    /**
     * Create heading element from section title
     */
    protected function createHeadingElement(string $title, array $headingConfig): array
    {
        return [
            'type' => 'heading',
            'level' => 1,
            'text' => $title,
            'style' => [
                'font_name' => 'Times New Roman',
                'font_size' => $headingConfig['fontSize'] ?? 14,
                'bold' => $headingConfig['bold'] ?? true,
                'alignment' => $headingConfig['alignment'] ?? 'center',
                'uppercase' => $headingConfig['uppercase'] ?? false,
                'space_before' => 240,
                'space_after' => 120,
            ],
        ];
    }

    /**
     * Get section-specific formatting
     */
    protected function getSectionFormatting(array $section): array
    {
        $formatting = $section['formatting'] ?? [];

        return [
            'margins' => [
                'top' => $formatting['margins']['top'] ?? 3,
                'bottom' => $formatting['margins']['bottom'] ?? 3,
                'left' => $formatting['margins']['left'] ?? 4,
                'right' => $formatting['margins']['right'] ?? 3,
            ],
            'orientation' => $formatting['orientation'] ?? 'portrait',
        ];
    }

    /**
     * Convert heading level string to number
     */
    protected function getLevelNumber(string $level): int
    {
        return match ($level) {
            'h1' => 2,
            'h2' => 3,
            'h3' => 4,
            default => 2,
        };
    }

    /**
     * Validate template rules structure
     *
     * @param array $rules
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validate(array $rules): array
    {
        $errors = [];

        // Check required top-level keys
        if (!isset($rules['formatting'])) {
            $errors[] = 'Missing required key: formatting';
        }

        if (!isset($rules['sections'])) {
            $errors[] = 'Missing required key: sections';
        } elseif (!is_array($rules['sections'])) {
            $errors[] = 'Sections must be an array';
        }

        // Validate formatting
        if (isset($rules['formatting'])) {
            $formattingErrors = $this->validateFormatting($rules['formatting']);
            $errors = array_merge($errors, $formattingErrors);
        }

        // Validate sections
        if (isset($rules['sections']) && is_array($rules['sections'])) {
            foreach ($rules['sections'] as $index => $section) {
                $sectionErrors = $this->validateSection($section, $index);
                $errors = array_merge($errors, $sectionErrors);
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Validate formatting structure
     */
    protected function validateFormatting(array $formatting): array
    {
        $errors = [];

        if (!isset($formatting['font'])) {
            $errors[] = 'Formatting: Missing font configuration';
        }

        if (!isset($formatting['margins'])) {
            $errors[] = 'Formatting: Missing margins configuration';
        }

        return $errors;
    }

    /**
     * Validate section structure
     */
    protected function validateSection(array $section, int $index): array
    {
        $errors = [];

        if (empty($section['title'])) {
            $errors[] = "Section {$index}: Missing title";
        }

        if (!isset($section['components'])) {
            $errors[] = "Section {$index}: Missing components configuration";
        }

        return $errors;
    }

    /**
     * Get sample frontend structure for reference
     */
    public static function getSampleFrontendStructure(): array
    {
        return [
            'formatting' => [
                'font' => [
                    'name' => 'Times New Roman',
                    'size' => 12,
                    'line_spacing' => 1.5,
                ],
                'page_size' => 'A4',
                'orientation' => 'portrait',
                'margins' => [
                    'top' => 3,
                    'bottom' => 3,
                    'left' => 4,
                    'right' => 3,
                ],
            ],
            'sections' => [
                [
                    'title' => 'BAB I PENDAHULUAN',
                    'description' => 'Bab pembuka',
                    'required' => true,
                    'order' => 1,
                    'components' => [
                        'heading' => [
                            'fontSize' => 14,
                            'alignment' => 'center',
                            'bold' => true,
                            'uppercase' => true,
                        ],
                        'subheadings' => [
                            'h1' => [
                                'enabled' => true,
                                'fontSize' => 12,
                                'style' => 'bold',
                                'alignment' => 'left',
                            ],
                        ],
                        'content' => [
                            'hasNumbering' => false,
                            'hasIndentation' => true,
                            'allowImages' => true,
                            'allowTables' => true,
                        ],
                        'pageBreakBefore' => true,
                    ],
                    'mainContent' => '<p>Konten utama section...</p>',
                    'headingItems' => [
                        [
                            'level' => 'h1',
                            'title' => '1.1 Latar Belakang',
                            'content' => '<p>Isi latar belakang...</p>',
                            'order' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}

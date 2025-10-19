<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Paragraph;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class TemplateGeneratorService
{
    protected PhpWord $phpWord;
    protected $section;
    protected $template;

    /**
     * Generate Word document from template rules
     */
    public function generateDocument(Template $template): string
    {
        $this->template = $template;
        $this->phpWord = new PhpWord();

        // Parse rules from JSON
        $rules = $this->parseRules($template->template_rules);

        // Apply default formatting
        $this->applyDefaultFormatting($rules['formatting'] ?? []);

        // Process sections
        foreach ($rules['sections'] ?? [] as $sectionData) {
            $this->addSection($sectionData);
        }

        // Save document
        return $this->saveDocument();
    }

    /**
     * Parse JSON rules to array
     */
    protected function parseRules(string $rules): array
    {
        return json_decode($rules, true) ?? [];
    }

    /**
     * Apply default document formatting
     */
    protected function applyDefaultFormatting(array $formatting): void
    {
        // Default font settings
        $defaultFont = $formatting['font'] ?? [];
        $this->phpWord->setDefaultFontName($defaultFont['name'] ?? 'Times New Roman');
        $this->phpWord->setDefaultFontSize($defaultFont['size'] ?? 12);

        // Default paragraph settings
        $this->phpWord->setDefaultParagraphStyle([
            'alignment' => Jc::BOTH,
            'spacing' => [
                'before' => Converter::pointToTwip($defaultFont['line_spacing'] ?? 1.5) * 20,
                'after' => Converter::pointToTwip($defaultFont['line_spacing'] ?? 1.5) * 20,
                'line' => ($defaultFont['line_spacing'] ?? 1.5) * 240,
                'lineRule' => 'auto'
            ]
        ]);
    }

    /**
     * Add section to document
     */
    protected function addSection(array $sectionData): void
    {
        // Create new section with margins
        $formatting = $sectionData['formatting'] ?? [];
        $margin = $formatting['margin'] ?? [];

        $this->section = $this->phpWord->addSection([
            'marginTop' => Converter::cmToTwip($margin['top'] ?? 3),
            'marginBottom' => Converter::cmToTwip($margin['bottom'] ?? 3),
            'marginLeft' => Converter::cmToTwip($margin['left'] ?? 4),
            'marginRight' => Converter::cmToTwip($margin['right'] ?? 3),
            'orientation' => $formatting['orientation'] ?? 'portrait',
        ]);

        // Process elements in this section
        foreach ($sectionData['elements'] ?? [] as $element) {
            $this->addElement($element);
        }
    }

    /**
     * Add element to section based on type
     */
    protected function addElement(array $element): void
    {
        $type = $element['type'] ?? 'paragraph';

        switch ($type) {
            case 'heading':
                $this->addHeading($element);
                break;
            case 'paragraph':
                $this->addParagraph($element);
                break;
            case 'list':
                $this->addList($element);
                break;
            case 'table':
                $this->addTable($element);
                break;
            case 'image':
                $this->addImage($element);
                break;
            case 'page_break':
                $this->section->addPageBreak();
                break;
            case 'text_break':
                $this->section->addTextBreak($element['count'] ?? 1);
                break;
            case 'line':
                $this->addLine($element);
                break;
            default:
                // Default to paragraph
                $this->addParagraph($element);
        }
    }

    /**
     * Add heading to section
     */
    protected function addHeading(array $element): void
    {
        $level = $element['level'] ?? 1;
        $text = $element['text'] ?? '';
        $style = $element['style'] ?? [];

        // Determine heading style name
        $styleName = 'Heading' . $level;

        // Custom font style for heading
        $fontStyle = [
            'name' => $style['font_name'] ?? 'Times New Roman',
            'size' => $style['font_size'] ?? (18 - ($level * 2)), // Decreasing size by level
            'bold' => $style['bold'] ?? true,
            'color' => $style['color'] ?? '000000',
        ];

        // Paragraph style
        $paragraphStyle = [
            'alignment' => $this->getAlignment($style['alignment'] ?? 'left'),
            'spaceBefore' => Converter::pointToTwip($style['space_before'] ?? 240),
            'spaceAfter' => Converter::pointToTwip($style['space_after'] ?? 120),
        ];

        $this->section->addText($text, $fontStyle, $paragraphStyle);
    }

    /**
     * Add paragraph to section
     */
    protected function addParagraph(array $element): void
    {
        $text = $element['text'] ?? '';
        $style = $element['style'] ?? [];

        $fontStyle = [
            'name' => $style['font_name'] ?? null,
            'size' => $style['font_size'] ?? null,
            'bold' => $style['bold'] ?? false,
            'italic' => $style['italic'] ?? false,
            'underline' => $style['underline'] ?? null,
            'color' => $style['color'] ?? null,
        ];

        $paragraphStyle = [
            'alignment' => $this->getAlignment($style['alignment'] ?? 'both'),
            'indentation' => [
                'firstLine' => $style['first_line_indent'] ?? Converter::cmToTwip(1.25),
            ],
            'spaceBefore' => $style['space_before'] ?? null,
            'spaceAfter' => $style['space_after'] ?? null,
        ];

        // Remove null values
        $fontStyle = array_filter($fontStyle, fn($value) => $value !== null);
        $paragraphStyle = array_filter($paragraphStyle, fn($value) => $value !== null);

        $this->section->addText($text, $fontStyle, $paragraphStyle);
    }

    /**
     * Add list to section
     */
    protected function addList(array $element): void
    {
        $items = $element['items'] ?? [];
        $listType = $element['list_type'] ?? 'bullet'; // bullet or number
        $level = $element['level'] ?? 0;

        $fontStyle = [
            'name' => $element['style']['font_name'] ?? null,
            'size' => $element['style']['font_size'] ?? null,
        ];

        $fontStyle = array_filter($fontStyle, fn($value) => $value !== null);

        foreach ($items as $item) {
            if ($listType === 'number') {
                $this->section->addListItem($item, $level, $fontStyle, null, null);
            } else {
                $this->section->addListItem($item, $level, $fontStyle);
            }
        }
    }

    /**
     * Add table to section
     */
    protected function addTable(array $element): void
    {
        $rows = $element['rows'] ?? [];
        $style = $element['style'] ?? [];

        $tableStyle = [
            'borderColor' => $style['border_color'] ?? '000000',
            'borderSize' => $style['border_size'] ?? 6,
            'alignment' => $this->getAlignment($style['alignment'] ?? 'center'),
            'width' => $style['width'] ?? 100, // percentage
            'unit' => 'pct'
        ];

        $table = $this->section->addTable($tableStyle);

        foreach ($rows as $rowData) {
            $table->addRow();
            $cells = $rowData['cells'] ?? [];

            foreach ($cells as $cellData) {
                $cell = $table->addCell(
                    $cellData['width'] ?? null,
                    $cellData['style'] ?? []
                );

                $cell->addText(
                    $cellData['text'] ?? '',
                    $cellData['font_style'] ?? [],
                    $cellData['paragraph_style'] ?? []
                );
            }
        }
    }

    /**
     * Add image to section
     */
    protected function addImage(array $element): void
    {
        $path = $element['path'] ?? '';
        $style = $element['style'] ?? [];

        if (empty($path)) {
            return;
        }

        // Check if path is absolute or relative
        $imagePath = Storage::path($path);

        if (!file_exists($imagePath)) {
            return;
        }

        $imageStyle = [
            'width' => $style['width'] ?? 100,
            'height' => $style['height'] ?? 100,
            'alignment' => $this->getAlignment($style['alignment'] ?? 'center'),
        ];

        $this->section->addImage($imagePath, $imageStyle);
    }

    /**
     * Add horizontal line
     */
    protected function addLine(array $element): void
    {
        $style = $element['style'] ?? [];

        $this->section->addLine([
            'weight' => $style['weight'] ?? 1,
            'width' => $style['width'] ?? 100,
            'height' => 0,
            'color' => $style['color'] ?? '000000',
        ]);
    }

    /**
     * Get alignment constant from string
     */
    protected function getAlignment(string $alignment): string
    {
        return match (strtolower($alignment)) {
            'left' => Jc::START,
            'center' => Jc::CENTER,
            'right' => Jc::END,
            'both', 'justify' => Jc::BOTH,
            default => Jc::START,
        };
    }

    /**
     * Save document to storage
     */
    protected function saveDocument(): string
    {
        $filename = 'template_' . $this->template->id . '_' . time() . '.docx';
        $path = 'templates' . DIRECTORY_SEPARATOR . $filename;

        // Get full storage path
        $storagePath = storage_path('app');
        $fullPath = $storagePath . DIRECTORY_SEPARATOR . $path;

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save document
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007');
        $writer->save($fullPath);

        // Return path with forward slashes for storage
        return str_replace(DIRECTORY_SEPARATOR, '/', $path);
    }

    /**
     * Get sample template rules structure
     */
    public static function getSampleRules(): array
    {
        return [
            'formatting' => [
                'page_size' => 'A4',
                'orientation' => 'portrait',
                'margin' => [
                    'top' => 3,
                    'bottom' => 3,
                    'left' => 4,
                    'right' => 3,
                ],
                'font' => [
                    'name' => 'Times New Roman',
                    'size' => 12,
                    'line_spacing' => 1.5,
                ],
            ],
            'sections' => [
                [
                    'type' => 'cover',
                    'formatting' => [
                        'margin' => [
                            'top' => 3,
                            'bottom' => 3,
                            'left' => 4,
                            'right' => 3,
                        ],
                        'orientation' => 'portrait',
                    ],
                    'elements' => [
                        [
                            'type' => 'heading',
                            'level' => 1,
                            'text' => 'JUDUL TEMPLATE',
                            'style' => [
                                'alignment' => 'center',
                                'bold' => true,
                                'font_size' => 16,
                            ],
                        ],
                        [
                            'type' => 'text_break',
                            'count' => 2,
                        ],
                        [
                            'type' => 'paragraph',
                            'text' => 'Oleh:',
                            'style' => [
                                'alignment' => 'center',
                            ],
                        ],
                    ],
                ],
                [
                    'type' => 'chapter',
                    'chapter_number' => 1,
                    'formatting' => [
                        'margin' => [
                            'top' => 3,
                            'bottom' => 3,
                            'left' => 4,
                            'right' => 3,
                        ],
                    ],
                    'elements' => [
                        [
                            'type' => 'heading',
                            'level' => 1,
                            'text' => 'BAB I PENDAHULUAN',
                            'style' => [
                                'alignment' => 'center',
                                'bold' => true,
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'level' => 2,
                            'text' => '1.1 Latar Belakang',
                            'style' => [
                                'alignment' => 'left',
                                'bold' => true,
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                            'style' => [
                                'alignment' => 'both',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

<?php

namespace App\Services;

use PhpOffice\PhpWord\Element\AbstractContainer;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Facades\Log;

/**
 * HtmlToWordConverter
 *
 * Converts HTML content (from Quill editor) to PhpWord elements
 * Handles common HTML tags: p, strong, em, u, ul, ol, li, table, img, etc.
 */
class HtmlToWordConverter
{
    protected Section $section;
    protected array $defaultFontStyle = [];
    protected array $defaultParagraphStyle = [];

    /**
     * Convert HTML to Word elements and add to section
     *
     * @param Section $section PhpWord section
     * @param string $html HTML content
     * @param array $defaultFontStyle Default font styling
     * @param array $defaultParagraphStyle Default paragraph styling
     */
    public function convertAndAdd(
        Section $section,
        string $html,
        array $defaultFontStyle = [],
        array $defaultParagraphStyle = []
    ): void {
        $this->section = $section;
        $this->defaultFontStyle = $defaultFontStyle;
        $this->defaultParagraphStyle = $defaultParagraphStyle;

        // Clean and prepare HTML
        $html = $this->prepareHtml($html);

        // Parse HTML
        $dom = $this->parseHtml($html);

        if ($dom && $dom->documentElement) {
            $this->processNode($dom->documentElement);
        }
    }

    /**
     * Prepare HTML for parsing
     */
    protected function prepareHtml(string $html): string
    {
        // Remove Quill editor specific classes
        $html = preg_replace('/class="ql-[^"]*"/', '', $html);

        // Ensure proper encoding
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        return $html;
    }

    /**
     * Parse HTML string to DOMDocument
     */
    protected function parseHtml(string $html): ?\DOMDocument
    {
        if (empty(trim($html))) {
            return null;
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);

        // Wrap content to ensure proper parsing
        $wrappedHtml = '<?xml encoding="UTF-8"><div>' . $html . '</div>';
        $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();

        return $dom;
    }

    /**
     * Process DOM node recursively
     */
    protected function processNode(\DOMNode $node, array $inheritedStyle = []): void
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            // Skip empty text nodes
            if (trim($node->nodeValue) === '') {
                return;
            }
        }

        switch ($node->nodeName) {
            case 'p':
                $this->processParagraph($node, $inheritedStyle);
                break;
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
                $this->processHeading($node, $inheritedStyle);
                break;
            case 'ul':
            case 'ol':
                $this->processList($node, $node->nodeName === 'ol', $inheritedStyle);
                break;
            case 'table':
                $this->processTable($node);
                break;
            case 'img':
                $this->processImage($node);
                break;
            case 'br':
                $this->section->addTextBreak();
                break;
            case 'strong':
            case 'b':
                $inheritedStyle['bold'] = true;
                $this->processChildren($node, $inheritedStyle);
                break;
            case 'em':
            case 'i':
                $inheritedStyle['italic'] = true;
                $this->processChildren($node, $inheritedStyle);
                break;
            case 'u':
                $inheritedStyle['underline'] = 'single';
                $this->processChildren($node, $inheritedStyle);
                break;
            case 'blockquote':
                $this->processBlockquote($node, $inheritedStyle);
                break;
            default:
                $this->processChildren($node, $inheritedStyle);
                break;
        }
    }

    /**
     * Process paragraph element
     */
    protected function processParagraph(\DOMNode $node, array $inheritedStyle = []): void
    {
        $textRun = $this->section->addTextRun($this->getParagraphStyle($node));
        $this->processInlineContent($node, $textRun, $inheritedStyle);
    }

    /**
     * Process heading element
     */
    protected function processHeading(\DOMNode $node, array $inheritedStyle = []): void
    {
        $level = (int) substr($node->nodeName, 1); // h1 -> 1
        $fontSize = 18 - ($level * 2); // Decreasing size

        $fontStyle = array_merge([
            'name' => 'Times New Roman',
            'size' => $fontSize,
            'bold' => true,
        ], $inheritedStyle);

        $paragraphStyle = [
            'alignment' => Jc::START,
            'spaceBefore' => 240,
            'spaceAfter' => 120,
        ];

        $text = $this->getNodeText($node);
        $this->section->addText($text, $fontStyle, $paragraphStyle);
    }

    /**
     * Process list (ul/ol)
     */
    protected function processList(\DOMNode $node, bool $isNumbered = false, array $inheritedStyle = [], int $depth = 0): void
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'li') {
                $text = $this->getNodeText($child);
                $fontStyle = array_merge($this->defaultFontStyle, $inheritedStyle);

                $this->section->addListItem(
                    $text,
                    $depth,
                    $fontStyle,
                    null,
                    $isNumbered ? null : null
                );

                // Handle nested lists
                foreach ($child->childNodes as $nested) {
                    if ($nested->nodeName === 'ul' || $nested->nodeName === 'ol') {
                        $this->processList($nested, $nested->nodeName === 'ol', $inheritedStyle, $depth + 1);
                    }
                }
            }
        }
    }

    /**
     * Process table element
     */
    protected function processTable(\DOMNode $node): void
    {
        $tableStyle = [
            'borderColor' => '000000',
            'borderSize' => 6,
            'cellMargin' => 80,
        ];

        $table = $this->section->addTable($tableStyle);

        // Process rows
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'tbody' || $child->nodeName === 'thead') {
                foreach ($child->childNodes as $row) {
                    if ($row->nodeName === 'tr') {
                        $this->processTableRow($table, $row, $child->nodeName === 'thead');
                    }
                }
            } elseif ($child->nodeName === 'tr') {
                $this->processTableRow($table, $child, false);
            }
        }
    }

    /**
     * Process table row
     */
    protected function processTableRow($table, \DOMNode $row, bool $isHeader = false): void
    {
        $table->addRow();

        foreach ($row->childNodes as $cellNode) {
            if ($cellNode->nodeName === 'td' || $cellNode->nodeName === 'th') {
                $cellStyle = [];
                $fontStyle = $this->defaultFontStyle;

                if ($isHeader || $cellNode->nodeName === 'th') {
                    $fontStyle['bold'] = true;
                    $cellStyle['bgColor'] = 'E0E0E0';
                }

                $cell = $table->addCell(2000, $cellStyle);
                $text = $this->getNodeText($cellNode);
                $cell->addText($text, $fontStyle);
            }
        }
    }

    /**
     * Process image element
     */
    protected function processImage(\DOMNode $node): void
    {
        $src = $node->attributes->getNamedItem('src')->nodeValue ?? '';

        if (empty($src)) {
            return;
        }

        // Handle base64 images
        if (strpos($src, 'data:image') === 0) {
            $this->processBase64Image($src);
            return;
        }

        // Handle URL images (skip for now - would need to download)
        // Could implement later if needed
    }

    /**
     * Process base64 encoded image
     */
    protected function processBase64Image(string $base64): void
    {
        try {
            // Extract image data
            preg_match('/data:image\/(\w+);base64,(.*)/', $base64, $matches);

            if (count($matches) !== 3) {
                return;
            }

            $extension = $matches[1];
            $imageData = base64_decode($matches[2]);

            // Create temporary file
            $tempPath = sys_get_temp_dir() . '/temp_image_' . uniqid() . '.' . $extension;
            file_put_contents($tempPath, $imageData);

            // Add image to document
            $this->section->addImage($tempPath, [
                'width' => 400,
                'height' => 300,
                'alignment' => Jc::CENTER,
            ]);

            // Clean up
            @unlink($tempPath);
        } catch (\Exception $e) {
            Log::warning('Failed to process base64 image: ' . $e->getMessage());
        }
    }

    /**
     * Process blockquote element
     */
    protected function processBlockquote(\DOMNode $node, array $inheritedStyle = []): void
    {
        $paragraphStyle = [
            'indentation' => [
                'left' => Converter::cmToTwip(1),
                'right' => Converter::cmToTwip(1),
            ],
            'spaceBefore' => 120,
            'spaceAfter' => 120,
        ];

        $textRun = $this->section->addTextRun($paragraphStyle);
        $fontStyle = array_merge($this->defaultFontStyle, $inheritedStyle, [
            'italic' => true,
            'color' => '666666',
        ]);

        $text = $this->getNodeText($node);
        $textRun->addText($text, $fontStyle);
    }

    /**
     * Process inline content in a TextRun
     */
    protected function processInlineContent(\DOMNode $node, $textRun, array $inheritedStyle = []): void
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                $text = $child->nodeValue;
                if (!empty(trim($text))) {
                    $fontStyle = array_merge($this->defaultFontStyle, $inheritedStyle);
                    $textRun->addText($text, $fontStyle);
                }
            } else {
                $style = $inheritedStyle;

                switch ($child->nodeName) {
                    case 'strong':
                    case 'b':
                        $style['bold'] = true;
                        break;
                    case 'em':
                    case 'i':
                        $style['italic'] = true;
                        break;
                    case 'u':
                        $style['underline'] = 'single';
                        break;
                    case 'a':
                        $style['color'] = '0000FF';
                        $style['underline'] = 'single';
                        break;
                }

                $this->processInlineContent($child, $textRun, $style);
            }
        }
    }

    /**
     * Process children nodes
     */
    protected function processChildren(\DOMNode $node, array $inheritedStyle = []): void
    {
        foreach ($node->childNodes as $child) {
            $this->processNode($child, $inheritedStyle);
        }
    }

    /**
     * Get paragraph style from node attributes
     */
    protected function getParagraphStyle(\DOMNode $node): array
    {
        $style = $this->defaultParagraphStyle;

        // Check for alignment in style attribute
        if ($node->attributes) {
            $styleAttr = $node->attributes->getNamedItem('style');
            if ($styleAttr) {
                $styleValue = $styleAttr->nodeValue;

                if (strpos($styleValue, 'text-align: center') !== false) {
                    $style['alignment'] = Jc::CENTER;
                } elseif (strpos($styleValue, 'text-align: right') !== false) {
                    $style['alignment'] = Jc::END;
                } elseif (strpos($styleValue, 'text-align: justify') !== false) {
                    $style['alignment'] = Jc::BOTH;
                }
            }

            $classAttr = $node->attributes->getNamedItem('class');
            if ($classAttr && strpos($classAttr->nodeValue, 'ql-align-center') !== false) {
                $style['alignment'] = Jc::CENTER;
            }
        }

        return $style;
    }

    /**
     * Get all text content from node
     */
    protected function getNodeText(\DOMNode $node): string
    {
        $text = '';

        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                $text .= $child->nodeValue;
            } else {
                $text .= $this->getNodeText($child);
            }
        }

        return $text;
    }
}

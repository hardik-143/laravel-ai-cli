<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use Laravel\Ai\Image;
use Laravel\Ai\Files;

class ImageModCommand extends Command
{
    protected $signature = 'ai:imagemod {image : Path to the image file to modify} {modification : Description of modifications to apply} {--output= : Optional output file path} {--dir= : Directory to save the image (defaults to project root)} {--count=1 : Number of variations to generate (1-4)} {--timeout=120 : HTTP timeout in seconds} {--metadata : Save modification metadata to JSON file}';
    protected $description = 'Modify or enhance an existing image based on your requirements';

    public function handle(): int
    {
        try {
            $imagePath = $this->argument('image');
            $modification = $this->argument('modification');

            if (empty(trim($modification))) {
                $this->error('Modification description cannot be empty.');
                return self::FAILURE;
            }

            // Validate image file path
            if (!$this->isValidFilePath($imagePath)) {
                $this->error('Invalid file path provided.');
                return self::FAILURE;
            }

            if (!is_file($imagePath)) {
                $this->error("Image file not found: {$imagePath}");
                return self::FAILURE;
            }

            if (!is_readable($imagePath)) {
                $this->error('Image file is not readable.');
                return self::FAILURE;
            }

            // Validate that it's an image file
            $mimeType = mime_content_type($imagePath);
            $validImageMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];

            if (!in_array($mimeType, $validImageMimes)) {
                $this->error('Invalid image file. Supported formats: JPEG, PNG, GIF, WebP, SVG');
                return self::FAILURE;
            }

            // Always ask for quality interactively
            $qualityOptions = ['high', 'medium', 'low'];
            $quality = $this->choice(
                'Select image quality:',
                $qualityOptions,
                'high'
            );

            // Always ask for aspect ratio interactively
            $aspectOptions = ['square', 'portrait', 'landscape', 'keep-original'];
            $aspect = $this->choice(
                'Select aspect ratio:',
                $aspectOptions,
                'keep-original'
            );

            $outputPath = $this->option('output');
            $dir = $this->option('dir');
            $count = (int) $this->option('count');
            $timeout = $this->option('timeout') ?? 120;

            // Validate count
            if ($count < 1 || $count > 4) {
                $this->error('Count must be between 1 and 4. Using default count of 1.');
                $count = 1;
            }

            $this->info('Processing image modification request...');
            $this->line("Quality: {$quality} | Aspect: {$aspect} | Count: {$count} | Timeout: {$timeout}s");

            // Generate modifications based on count
            $savedFiles = [];
            for ($i = 1; $i <= $count; $i++) {
                // Add variation instruction to make each modification unique
                $uniqueId = uniqid();
                $enhancedModification = $modification . " (Variation #{$uniqueId})";

                // Modify image using Laravel AI with attachments
                $imageBuilder = Image::of($enhancedModification)
                    ->attachments([
                        Files\Image::fromPath($imagePath),
                    ])
                    ->quality($quality)
                    ->timeout((int) $timeout);

                // Apply aspect ratio method if not keeping original
                if ($aspect === 'landscape') {
                    $imageBuilder->landscape();
                } elseif ($aspect === 'portrait') {
                    $imageBuilder->portrait();
                } elseif ($aspect === 'square') {
                    $imageBuilder->square();
                }

                $variationText = $count > 1 ? "Generating image modification {$i}/{$count}..." : "Generating image modification...";
                $this->line($variationText);
                $modifiedImage = $imageBuilder->generate();
                $rawContent = (string) $modifiedImage;

                // Determine output path
                if ($outputPath) {
                    // If custom output path, add counter to filename
                    if ($count > 1) {
                        $pathInfo = pathinfo($outputPath);
                        $outputWithCounter = $pathInfo['dirname'] . DIRECTORY_SEPARATOR .
                            $pathInfo['filename'] . "_{$i}." .
                            ($pathInfo['extension'] ?? 'png');
                    } else {
                        $outputWithCounter = $outputPath;
                    }
                    if (!$this->saveImage($rawContent, $outputWithCounter)) {
                        return self::FAILURE;
                    }
                    $savedFiles[] = $outputWithCounter;
                } else {
                    // Use --dir if provided, otherwise use base_path
                    $basePath = $dir ? base_path($dir) : base_path();

                    // Create directory if it doesn't exist
                    if (!is_dir($basePath)) {
                        if (!mkdir($basePath, 0755, true)) {
                            $this->error("Failed to create directory: {$basePath}");
                            return self::FAILURE;
                        }
                    }

                    $timestamp = date('Y-m-d_H-i-s');
                    $filename = "IMAGE_MOD_{$timestamp}_{$i}.png";
                    $fullPath = $basePath . DIRECTORY_SEPARATOR . $filename;
                    if (!$this->saveImage($rawContent, $fullPath)) {
                        return self::FAILURE;
                    }
                    $savedFiles[] = $fullPath;
                }
            }

            // Summary
            $summaryText = $count > 1 ? "Successfully generated {$count} image modifications!" : "Successfully generated image modification!";
            $this->info("\n✓ {$summaryText}");
            foreach ($savedFiles as $index => $file) {
                $this->line(($index + 1) . ". {$file}");
            }

            // Save metadata if --metadata flag is provided
            if ($this->option('metadata')) {
                $this->saveMetadata($modification, $quality, $aspect, $count, $timeout, $imagePath, $savedFiles, 'modification');
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Save modified image to file
     */
    private function saveImage(string $imageContent, string $outputPath): bool
    {
        try {
            if (file_put_contents($outputPath, $imageContent) === false) {
                $this->error('Failed to save image to file.');
                return false;
            }

            return true;
        } catch (\Exception $e) {
            $this->error('Error saving image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Save modification metadata to JSON file
     */
    private function saveMetadata(string $modification, string $quality, string $aspect, int $count, int $timeout, string $imagePath, array $savedFiles, string $type): void
    {
        try {
            $metadata = [
                'type' => $type,
                'timestamp' => date('Y-m-d H:i:s'),
                'source_image' => $imagePath,
                'modification' => $modification,
                'settings' => [
                    'quality' => $quality,
                    'aspect_ratio' => $aspect,
                    'count' => $count,
                    'timeout' => $timeout,
                ],
                'generated_files' => $savedFiles,
                'file_count' => count($savedFiles),
            ];

            // Save metadata in the same directory as the images
            if (!empty($savedFiles)) {
                $firstFile = $savedFiles[0];
                $dir = dirname($firstFile);
                $timestamp = date('Y-m-d_H-i-s');
                $metadataFile = $dir . DIRECTORY_SEPARATOR . "metadata_{$timestamp}.json";

                if (file_put_contents($metadataFile, json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false) {
                    $this->line("\n<info>📋 Metadata saved to:</info> {$metadataFile}");
                }
            }
        } catch (\Exception $e) {
            $this->warn("Warning: Could not save metadata: " . $e->getMessage());
        }
    }

    /**
     * Validate file path to prevent directory traversal and other attacks
     */
    private function isValidFilePath(string $file): bool
    {
        // Prevent absolute paths outside project
        if (str_starts_with($file, '/') && !str_starts_with($file, base_path())) {
            return false;
        }

        // Prevent directory traversal
        if (str_contains($file, '..')) {
            return false;
        }

        return true;
    }
}

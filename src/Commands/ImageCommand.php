<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use Laravel\Ai\Image;

class ImageCommand extends Command
{
    protected $signature = 'ai:image {prompt : Image description or prompt} {--output= : Optional output file path for the generated image} {--dir= : Directory to save the image (defaults to project root)} {--count=1 : Number of images to generate (1-4)} {--timeout=120 : HTTP timeout in seconds} {--metadata : Save generation metadata to JSON file}';
    protected $description = 'Generate an image from a text description using AI';

    public function handle(): int
    {
        try {
            $prompt = $this->argument('prompt');

            if (empty(trim($prompt))) {
                $this->error('Prompt cannot be empty.');
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
            $aspectOptions = ['square', 'portrait', 'landscape'];
            $aspect = $this->choice(
                'Select aspect ratio:',
                $aspectOptions,
                'square'
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

            $this->info('Generating image from your description...');
            $this->line("Quality: {$quality} | Aspect: {$aspect} | Count: {$count} | Timeout: {$timeout}s");

            // Generate images based on count
            $savedFiles = [];
            for ($i = 1; $i <= $count; $i++) {
                // Add variation instruction to make each generation unique
                $uniqueId = uniqid();
                $enhancedPrompt = $prompt . " (Variation #{$uniqueId})";

                // Generate image using Laravel AI with options
                $imageBuilder = Image::of($enhancedPrompt)
                    ->quality($quality)
                    ->timeout((int) $timeout);

                // Apply aspect ratio method
                if ($aspect === 'landscape') {
                    $imageBuilder->landscape();
                } elseif ($aspect === 'portrait') {
                    $imageBuilder->portrait();
                } else {
                    $imageBuilder->square();
                }

                $generateText = $count > 1 ? "Generating image {$i}/{$count}..." : "Generating image...";
                $this->line($generateText);
                $image = $imageBuilder->generate();
                $rawContent = (string) $image;

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
                    $filename = "IMAGE_{$timestamp}_{$i}.png";
                    $fullPath = $basePath . DIRECTORY_SEPARATOR . $filename;
                    if (!$this->saveImage($rawContent, $fullPath)) {
                        return self::FAILURE;
                    }
                    $savedFiles[] = $fullPath;
                }
            }

            // Summary
            $summaryText = $count > 1 ? "Successfully generated {$count} images!" : "Successfully generated image!";
            $this->info("\n✓ {$summaryText}");
            foreach ($savedFiles as $index => $file) {
                $this->line(($index + 1) . ". {$file}");
            }

            // Save metadata if --metadata flag is provided
            if ($this->option('metadata')) {
                $this->saveMetadata($prompt, $quality, $aspect, $count, $timeout, $savedFiles, 'generation');
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Save generated image to file
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
     * Save generation metadata to JSON file
     */
    private function saveMetadata(string $prompt, string $quality, string $aspect, int $count, int $timeout, array $savedFiles, string $type): void
    {
        try {
            $metadata = [
                'type' => $type,
                'timestamp' => date('Y-m-d H:i:s'),
                'prompt' => $prompt,
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
}

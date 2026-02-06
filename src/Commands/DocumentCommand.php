<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\MarkdownDocumentAgent;

class DocumentCommand extends Command
{
    protected $signature = 'ai:document {file}';
    protected $description = 'Generate documentation for code (display in terminal or save to file)';

    public function handle(): int
    {
        $file = $this->argument('file');

        // Validate file path to prevent directory traversal attacks
        if (! $this->isValidFilePath($file)) {
            $this->error('Invalid file path provided.');
            return self::FAILURE;
        }

        if (! is_file($file)) {
            $this->error('File not found.');
            return self::FAILURE;
        }

        if (! is_readable($file)) {
            $this->error('File is not readable.');
            return self::FAILURE;
        }

        try {
            $code = file_get_contents($file);

            if ($code === false) {
                $this->error('Failed to read file.');
                return self::FAILURE;
            }

            // Ask user for output preference
            $output = $this->choice(
                'How would you like to receive the documentation?',
                [
                    'terminal' => 'Display in terminal',
                    'file' => 'Save to file (DOCUMENTATION_{filename}.md)',
                ],
                'terminal'
            );

            $this->info('Generating documentation...');

            $response = app(MarkdownDocumentAgent::class)->prompt(
                "Generate comprehensive markdown documentation for the following code:\n\n{$code}"
            );

            if ($output === 'file') {
                return $this->saveToFile($file, $response);
            } else {
                $this->displayInTerminal($response);
                return self::SUCCESS;
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Save documentation to file
     */
    private function saveToFile(string $file, mixed $response): int
    {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $outputFile = base_path("DOCUMENTATION_{$filename}.md");

        if (file_put_contents($outputFile, (string) $response) === false) {
            $this->error('Failed to write documentation file.');
            return self::FAILURE;
        }

        $this->info("✓ Documentation saved to: {$outputFile}");
        $this->line('');
        $this->line('Preview:');
        $this->displayInTerminal($response);

        return self::SUCCESS;
    }

    /**
     * Display documentation in terminal
     */
    private function displayInTerminal(mixed $response): void
    {
        $this->line('');
        $this->line(str_repeat('─', 80));
        $this->line((string) $response);
        $this->line(str_repeat('─', 80));
    }

    /**
     * Validate file path to prevent directory traversal and other attacks
     */
    private function isValidFilePath(string $file): bool
    {
        // Prevent absolute paths outside project
        if (str_starts_with($file, '/') && ! str_starts_with($file, base_path())) {
            return false;
        }

        // Prevent directory traversal
        if (str_contains($file, '..')) {
            return false;
        }

        return true;
    }
}

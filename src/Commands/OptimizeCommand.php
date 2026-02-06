<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\OptimizeAgent;

class OptimizeCommand extends Command
{
    protected $signature = 'ai:optimize {file}';
    protected $description = 'Optimize code for performance';

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

            $response = app(OptimizeAgent::class)->prompt(
                "Optimize the following code:\n\n{$code}"
            );

            $this->line((string) $response);
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
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

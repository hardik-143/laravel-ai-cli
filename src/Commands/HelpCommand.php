<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;

class HelpCommand extends Command
{
    protected $signature = 'ai';
    protected $description = 'Show information about Laravel AI CLI and available commands';

    public function handle(): int
    {
        $this->displayBanner();
        $this->displayAbout();
        $this->displayCommands();

        return self::SUCCESS;
    }

    private function displayBanner(): void
    {
        $this->line('');
        $this->line('<fg=cyan;options=bold>╔══════════════════════════════════════════════════════════════╗</>');
        $this->line('<fg=cyan;options=bold>║</>                                                              <fg=cyan;options=bold>║</>');
        $this->line('<fg=cyan;options=bold>║</>           <fg=yellow;options=bold>🤖  Laravel AI CLI  🚀</>                             <fg=cyan;options=bold>║</>');
        $this->line('<fg=cyan;options=bold>║</>                                                              <fg=cyan;options=bold>║</>');
        $this->line('<fg=cyan;options=bold>╚══════════════════════════════════════════════════════════════╝</>');
        $this->line('');
    }

    private function displayAbout(): void
    {
        $this->line('<fg=green;options=bold>📦 Package Information:</>');
        $this->line('  <fg=white;options=bold>Name:</> <fg=cyan>laravel-ai/cli</>');
        $this->line('  <fg=white;options=bold>Description:</> <fg=cyan>AI-powered CLI tools for Laravel using Laravel AI SDK</>');
        $this->line('  <fg=white;options=bold>Version:</> <fg=cyan>v1.0.4</>');
        $this->line('  <fg=white;options=bold>License:</> <fg=cyan>MIT</>');
        $this->line('');
    }

    private function displayCommands(): void
    {
        $this->line('<fg=green;options=bold>📋 Available Commands:</>');
        $this->line('');

        $commands = [
            [
                'name' => 'ai:ask',
                'description' => 'Ask AI a question',
                'usage' => 'ai:ask {prompt}'
            ],
            [
                'name' => 'ai:document',
                'description' => 'Generate documentation for code',
                'usage' => 'ai:document {file}'
            ],
            [
                'name' => 'ai:explain',
                'description' => 'Explain what code does',
                'usage' => 'ai:explain {file}'
            ],
            [
                'name' => 'ai:image',
                'description' => 'Generate image from text description',
                'usage' => 'ai:image {prompt}'
            ],
            [
                'name' => 'ai:image-mod',
                'description' => 'Modify an existing image',
                'usage' => 'ai:image-mod {image_path} {prompt}'
            ],
            [
                'name' => 'ai:optimize',
                'description' => 'Optimize code for performance',
                'usage' => 'ai:optimize {file}'
            ],
            [
                'name' => 'ai:refactor',
                'description' => 'Refactor code for better quality and maintainability',
                'usage' => 'ai:refactor {file}'
            ],
            [
                'name' => 'ai:review',
                'description' => 'Review code for best practices and improvements',
                'usage' => 'ai:review {file}'
            ],
            [
                'name' => 'ai',
                'description' => 'Show this help information',
                'usage' => 'ai'
            ],
        ];

        foreach ($commands as $cmd) {
            $this->line("  <fg=yellow;options=bold>{$cmd['name']}</>");
            $this->line("    <fg=cyan>{$cmd['description']}</>");
            $this->line("    <fg=gray>Usage: {$cmd['usage']}</>");
            $this->line('');
        }

        $this->line('<fg=green;options=bold>💡 Quick Start:</>');
        $this->line('  <fg=cyan>Ask a question:</> php artisan ai:ask "How do I create a model?"');
        $this->line('  <fg=cyan>Document code:</> php artisan ai:document app/Models/User.php');
        $this->line('  <fg=cyan>Refactor code:</> php artisan ai:refactor app/Http/Controllers/UserController.php');
        $this->line('  <fg=cyan>Review code:</> php artisan ai:review app/Services/UserService.php');
        $this->line('');
    }
}

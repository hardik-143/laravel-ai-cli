<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\ExplainAgent;

class ExplainCommand extends Command
{
    protected $signature = 'ai:explain {file}';
    protected $description = 'Explain a file';

    public function handle(): void
    {
        $file = $this->argument('file');

        if (! is_file($file)) {
            $this->error('File not found.');
            return;
        }

        $content = file_get_contents($file);

        $response = app(ExplainAgent::class)->prompt(
            "Explain the following file:\n\n{$content}"
        );

        $this->line((string) $response);
    }
}

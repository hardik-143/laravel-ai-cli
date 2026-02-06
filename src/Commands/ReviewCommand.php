<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\ReviewAgent;

class ReviewCommand extends Command
{
    protected $signature = 'ai:review {file}';
    protected $description = 'Review a source code file';

    public function handle(): void
    {
        $file = $this->argument('file');

        if (! is_file($file)) {
            $this->error('File not found.');
            return;
        }

        $code = file_get_contents($file);

        $response = app(ReviewAgent::class)->prompt(
            "Review the following code:\n\n{$code}"
        );

        $this->line((string) $response);
    }
}

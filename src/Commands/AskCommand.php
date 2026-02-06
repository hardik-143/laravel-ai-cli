<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\AskAgent;

class AskCommand extends Command
{
    protected $signature = 'ai:ask {prompt}';
    protected $description = 'Ask AI a question';

    public function handle(): void
    {
        $response = app(AskAgent::class)
            ->prompt($this->argument('prompt'));

        $this->line((string) $response);
    }
}

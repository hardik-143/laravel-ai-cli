<?php

namespace LaravelAiCli\Commands;

use Illuminate\Console\Command;
use LaravelAiCli\Ai\Agents\AskAgent;

class AskCommand extends Command
{
    protected $signature = 'ai:ask {prompt}';
    protected $description = 'Ask AI a question';

    public function handle(): int
    {
        try {
            $prompt = $this->argument('prompt');

            if (empty(trim($prompt))) {
                $this->error('Prompt cannot be empty.');
                return self::FAILURE;
            }

            $response = app(AskAgent::class)
                ->prompt($prompt);

            $this->line((string) $response);
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}

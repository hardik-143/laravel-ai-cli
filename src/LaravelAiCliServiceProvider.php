<?php

namespace LaravelAiCli;

use Illuminate\Support\ServiceProvider;
use LaravelAiCli\Commands\{
    AskCommand,
    ExplainCommand,
    ReviewCommand
};

class LaravelAiCliServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AskCommand::class,
                ExplainCommand::class,
                ReviewCommand::class,
            ]);
        }
    }
}

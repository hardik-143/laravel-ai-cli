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
    /**
     * Bootstrap any package services.
     */
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

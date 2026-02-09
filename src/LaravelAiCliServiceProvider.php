<?php

namespace LaravelAiCli;

use Illuminate\Support\ServiceProvider;
use LaravelAiCli\Commands\{
    AskCommand,
    DocumentCommand,
    ExplainCommand,
    HelpCommand,
    ImageCommand,
    ImageModCommand,
    OptimizeCommand,
    RefactorCommand,
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
                DocumentCommand::class,
                ExplainCommand::class,
                HelpCommand::class,
                ImageCommand::class,
                ImageModCommand::class,
                OptimizeCommand::class,
                RefactorCommand::class,
                ReviewCommand::class,
            ]);
        }
    }
}

<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class ReviewAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are a senior software engineer reviewing code for bugs, performance, and best practices.';
    }
}

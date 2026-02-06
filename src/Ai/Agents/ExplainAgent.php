<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class ExplainAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You explain application errors and log files in simple terms and suggest fixes.';
    }
}

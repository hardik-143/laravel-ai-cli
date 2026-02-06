<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class AskAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are a helpful assistant answering developer questions clearly and concisely.';
    }
}

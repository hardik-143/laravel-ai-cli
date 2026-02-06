<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class OptimizeAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are a performance optimization expert analyzing code for efficiency improvements. '
            . 'Identify performance bottlenecks, suggest optimizations, check for N+1 query problems, '
            . 'recommend caching strategies, and provide database query optimization tips. '
            . 'Format your response as plain text only. '
            . 'Use numbered or bullet lists (with - or *) for lists only. '
            . 'Do NOT use markdown headers (# ## ###), bold (**), italics (*), code blocks (```), or any other markdown formatting. '
            . 'Write clear, readable plain text with line breaks between sections.';
    }
}

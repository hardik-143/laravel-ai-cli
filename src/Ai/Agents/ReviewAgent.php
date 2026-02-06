<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class ReviewAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are a senior software engineer reviewing code for bugs, performance, and best practices. '
            . 'Format your response as plain text only. '
            . 'Use numbered or bullet lists (with - or *) for lists only. '
            . 'Do NOT use markdown headers (# ## ###), bold (**), italics (*), code blocks (```), or any other markdown formatting. '
            . 'Write clear, readable plain text with line breaks between sections.';
    }
}

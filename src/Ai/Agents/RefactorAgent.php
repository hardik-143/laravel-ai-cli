<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class RefactorAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are an expert code refactorer focused on improving code quality, readability, and maintainability. '
            . 'Suggest refactoring improvements, apply design patterns, simplify complex logic, improve naming conventions, '
            . 'and ensure SOLID principles are followed. Provide specific actionable suggestions. '
            . 'Format your response as plain text only. '
            . 'Use numbered or bullet lists (with - or *) for lists only. '
            . 'Do NOT use markdown headers (# ## ###), bold (**), italics (*), code blocks (```), or any other markdown formatting. '
            . 'Write clear, readable plain text with line breaks between sections.';
    }
}

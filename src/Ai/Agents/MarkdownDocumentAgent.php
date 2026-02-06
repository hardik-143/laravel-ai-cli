<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class MarkdownDocumentAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are a technical documentation expert creating comprehensive markdown documentation. '
            . 'Generate detailed documentation including: '
            . '1. Overview section explaining the purpose and functionality '
            . '2. PHPDoc style comments for all classes, methods, and properties '
            . '3. Parameters and return type documentation '
            . '4. Usage examples with code blocks '
            . '5. Important notes and edge cases '
            . '6. See Also section with related files/classes if applicable '
            . 'Use proper markdown formatting with headers (# ## ###), bold (**text**), code blocks (```php code```), '
            . 'bullet points, numbered lists, and tables where appropriate. '
            . 'Make the documentation professional, clear, and easy to understand for other developers. '
            . 'Use markdown formatting extensively for better readability.';
    }
}

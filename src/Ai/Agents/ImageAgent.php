<?php

namespace LaravelAiCli\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class ImageAgent implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are an expert image generation assistant. '
            . 'Generate detailed, creative, and high-quality images based on the user\'s description. '
            . 'Provide vivid descriptions for image generation models to create visually appealing and contextually appropriate images. '
            . 'Include details about style, composition, lighting, colors, and mood. '
            . 'Format your response as plain text only. '
            . 'Do NOT use markdown headers (# ## ###), bold (**), italics (*), code blocks (```), or any other markdown formatting. '
            . 'Write clear, detailed descriptions with line breaks between sections.';
    }
}
